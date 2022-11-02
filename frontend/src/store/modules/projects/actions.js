import { HttpAuth } from "@/config/axiosConfig";

const actions = {
    // Busca um produto em especifico
    getProject: (context, id) => {
        return context.state.listProducts.filter(data => data.id == id);
    },

    // Busca os produtos
    getProjects({ commit }) {
        return HttpAuth.get('projects')
            .then((res) => {
                commit('SET_PROJECTS', res.data.data)
            })
            .catch(error => {
                console.log(error)
            })
    },

    // Deleta um produto
    deleteProject({ dispatch }, id) {
        return HttpAuth.post(`/project/${id}/delete`)
            .then((res) => {
                dispatch('getProjects')
                // eslint-disable-next-line no-undef
                Toast.fire(`O projeto foi apagado com sucesso.`, "", "success");
                return true;
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // Metodo responsável por realizar a inserção de um novo produto
    storeProject({ dispatch }, obj) {
        return HttpAuth.post("project/", obj)
            .then((res) => {
                // eslint-disable-next-line no-undef
                Toast.fire(`Projeto criado com sucesso.`, "", "success");
                dispatch('getProjects')
                return true;
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // Responsável por alterar os dados de um produto
    updateProject({ commit }, { obj, form }) {
        // Processa a api
        return fetch(this.state.apiURL + "products/" + obj.id + "/edit", { method: "POST", body: form })
            .then(function (response) {
                if (response.ok) {
                    // Altera na listagem
                    commit("updateProductMutation", obj);

                    // eslint-disable-next-line no-undef
                    Toast.fire(`O produto foi alterado com sucesso.`, "", "success");
                    return true;
                } else {
                    // eslint-disable-next-line no-undef
                    Toast.fire("Ocorreu um erro ao tentar alterar o produto.", "", "error");
                    return false;
                }
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

};

export default actions;
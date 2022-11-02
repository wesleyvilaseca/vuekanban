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
    async deleteProject({ dispatch }, id) {
        return await HttpAuth.post(`/project/${id}/delete`)
            .then((res) => {
                dispatch('getProjects')
                // eslint-disable-next-line no-undef
                Toast.fire(`O projeto foi apagado com sucesso.`, "", "success");
                return true;
            })
            .catch(error => {
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
            .catch(error => {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // Responsável por alterar os dados de um produto
    updateProject({ dispatch }, { form, id }) {
        // Processa a api
        return HttpAuth.post(`project/${id}/edit`, form)
            .then(res => {
                // eslint-disable-next-line no-undef
                Toast.fire(`O projeto foi alterado com sucesso.`, "", "success");
                dispatch('getProjects');
                return true;
            })
            .catch(error => {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

};

export default actions;
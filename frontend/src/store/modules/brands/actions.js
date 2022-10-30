const actions = {
    // Busca as marcas
    fetchBrands({ commit }) {
        console.log("busca marcas")
        fetch(this.state.apiURL + "brands")
            .then(response => response.json())
            .then(dados => {
                commit("setBrands", dados.data)
            })
    },

    // Deleta uma marca
    deleteBrand({ commit }, item) {
        fetch(this.state.apiURL + "brands/" + item.id + "/remove", { method: "POST" })
            .then(function (response) {
                if (response.ok) {
                    commit("removeBrand", item.id)
                    // eslint-disable-next-line no-undef
                    Toast.fire(`A marca ${item.name} foi deletada com sucesso.`, "", "success");
                } else {
                    // eslint-disable-next-line no-undef
                    Toast.fire("Ocorreu um erro ao tentar deletar a marca.", "", "error");
                }
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // Metodo responsável por realizar a inserção de uma nova marca
    insertBrand({ commit }, item) {
        // eslint-disable-line no-unused-vars

        // Repassa para obj
        // var list = context.state.listBrands;

        // Processa a api
        fetch(this.state.apiURL + "brands/", { method: "POST", body: item })
            .then(function (response) {
                if (response.ok) {
                    // Recupera o retorno
                    let data = response.json();

                    // data = data.data;

                    // console.log(data);

                    // // Atualiza a lista
                    // list.push(data);

                    //só para parar o erro
                    commit("setBrands", '')

                    // eslint-disable-next-line no-undef
                    Toast.fire(`A marca ${item.name} foi inserida com sucesso.`, "", "success");
                    return data.data;

                } else {
                    // eslint-disable-next-line no-undef
                    Toast.fire("Ocorreu um erro ao tentar inserir a marca.", "", "error");
                }
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // Responsável por alterar os dados de uma marca
    updateBrand({commit}, { obj, form }) {
        // Processa a api
        return fetch(this.state.apiURL + "brands/" + obj.id + "/edit", { method: "POST", body: form })
            .then(function (response) {
                if (response.ok) {
                    // Altera na listagem
                    commit("updateBrandMutation", obj);

                    // eslint-disable-next-line no-undef
                    Toast.fire(`A marca foi alterada com sucesso.`, "", "success");
                    return true;
                } else {
                    // eslint-disable-next-line no-undef
                    Toast.fire("Ocorreu um erro ao tentar editar.", "", "error");
                    return false;
                }
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    }
}

export default actions;
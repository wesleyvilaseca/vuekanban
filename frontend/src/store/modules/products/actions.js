const actions = {
    // Busca um produto em especifico
    getProductId: (context, id) => {
        return context.state.listProducts.filter(data => data.id == id);
    },

    // Busca os produtos
    fetchProducts({ commit }) {
        console.log("busca produtos")
        fetch(this.state.apiURL + "products")
            .then(response => response.json())
            .then(dados => {
                commit("setProducts", dados.data)
                return true;
            })
    },

    // Deleta um produto
    deleteProducts({commit}, item) {
        fetch(this.state.apiURL + "products/" + item.id + "/remove", { method: "POST" })
            .then(function (response) {
                if (response.ok) {
                    commit("removeProduct", item.id)
                    // eslint-disable-next-line no-undef
                    Toast.fire(`O produto ${item.title} foi deletado com sucesso.`, "", "success");
                } else {
                    // eslint-disable-next-line no-undef
                    Toast.fire("Ocorreu um erro ao tentar deletar o produto.", "", "error");
                }
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // Metodo responsável por realizar a inserção de um novo produto
    insertProduct({commit}, item) {
        // Repassa para obj
        // var list = this.state.listProducts;

        // Processa a api
        fetch(this.state.apiURL + "products/", { method: "POST", body: item })
            .then(function (response) {
                if (response.ok) {
                    // Recupera o retorno
                    // let data = response.json();
                    // data = data.data;

                    // // Atualiza a lista
                    // list.push(data);

                    // salva a lista atualizada
                    commit("setProducts", '')
                    // eslint-disable-next-line no-undef
                    Toast.fire(`O produto foi inserido com sucesso.`, "", "success");
                    return true;
                } else {
                    // eslint-disable-next-line no-undef
                    Toast.fire("Ocorreu um erro ao tentar inserir o produto.", "", "error");
                }
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // Responsável por alterar os dados de um produto
    updateProduct({commit}, { obj, form }) {
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
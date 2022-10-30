export default {

    // Busca os options value
    fetchOptionsValue(context) {
        console.log("busca options value")
        fetch(context.rootState.apiURL + "options-value")
            .then(response => response.json())
            .then(dados => {
                context.commit("setOptionsValue", dados.data)
                return true;
            })
    },

    deleteValueOption(context, item) {
        fetch(context.rootState.apiURL + "options-value/" + item.id + "/remove", {method: "POST"})
            .then(function (response) {
                if (response.ok) {
                    context.commit("removeOptionValue", item.id)
                    // eslint-disable-next-line no-undef
                    Toast.fire(`O item ${item.name} foi deletado com sucesso.`, "", "success");
                } else {
                    // eslint-disable-next-line no-undef
                    Toast.fire("Ocorreu um erro ao tentar deletar o item.", "", "error");
                }
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // Metodo responsável por realizar a inserção de um novo produto
    insertOptionValue(context, item) {
        // Processa a api
        fetch(context.rootState.apiURL + "options-value/", {method: "POST", body: item})
            .then(function (response) {
                if (response.ok) {
                    context.dispatch("fetchOptionsValue");

                    // eslint-disable-next-line no-undef
                    Toast.fire(`O valor foi inserido com sucesso.`, "", "success");
                } else {
                    // eslint-disable-next-line no-undef
                    Toast.fire("Ocorreu um erro ao tentar inserir o valor.", "", "error");
                }
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // -------------------------------------------

    // Busca uma option em especifico
    getOptionId: (context, id) => {
        return context.state.listOptions.filter(data => data.id == id)
    },

    // Busca os options
    fetchOptions(context) {
        console.log("busca options")
        fetch(context.rootState.apiURL + "options")
            .then(response => response.json())
            .then(dados => {
                context.commit("setOptions", dados.data)
                return true;
            })
    },

    // Deleta um produto
    deleteOptions(context, item) {
        fetch(context.rootState.apiURL + "options/" + item.id + "/remove", {method: "POST"})
            .then(function (response) {
                if (response.ok) {
                    context.commit("removeOption", item.id)
                    // eslint-disable-next-line no-undef
                    Toast.fire(`O item ${item.title} foi deletado com sucesso.`, "", "success");
                } else {
                    // eslint-disable-next-line no-undef
                    Toast.fire("Ocorreu um erro ao tentar deletar o item.", "", "error");
                }
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // Metodo responsável por realizar a inserção de um novo produto
    insertOption(context, item) {
        // Repassa para obj
        var list = context.state.listOptions;

        // Processa a api
        fetch(context.rootState.apiURL + "options/", {method: "POST", body: item})
            .then(function (response) {
                if (response.ok) {
                    // Recupera o retorno
                    let data = response.json();
                    data = data.data;

                    // Atualiza a lista
                    list.push(data);

                    // salva a lista atualizada
                    context.commit("setOptions", list)

                    // eslint-disable-next-line no-undef
                    Toast.fire(`O item foi inserido com sucesso.`, "", "success");
                } else {
                    // eslint-disable-next-line no-undef
                    Toast.fire("Ocorreu um erro ao tentar inserir o item.", "", "error");
                }
            })
            .catch(function (error) {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // Altera um option
    updateOption(context, {obj, form}) {
        // Processa a api
        return fetch(context.rootState.apiURL + "options/" + obj.id + "/edit", {method: "POST", body: form})
            .then(function (response) {
                if (response.ok) {
                    // Altera na listagem
                    context.commit("updateOptionMutation", obj);

                    // eslint-disable-next-line no-undef
                    Toast.fire(`A informação foi alterada com sucesso.`, "", "success");
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
    },
}
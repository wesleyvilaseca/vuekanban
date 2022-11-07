import { HttpAuth } from "@/config/axiosConfig";

const actions = {
    getBoard({ commit }, projectid) {
        return HttpAuth.get(`board/${projectid}`)
            .then(res => {
                commit("SET_BOARD", res.data.data)
            })
    },
    storeBoard({ dispatch }, obj) {
        return HttpAuth.post('board', obj)
            .then(res => {
                dispatch('getBoard', obj.project_id)
            })
            .catch(error => {
                this.Toast.fire(error.message, "", "error");
            })
    },

    // Deleta um produto
    async deleteBoard({ dispatch }, board) {
        return await HttpAuth.post(`/board/${board.id}/delete`)
            .then((res) => {
                // eslint-disable-next-line no-undef
                Toast.fire(`O board foi apagado com sucesso.`, "", "success");
                return true;
            })
            .catch(error => {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },

    // Responsável por alterar os dados de um produto
    updateBoard({ dispatch }, { form, id }) {
        // Processa a api
        return HttpAuth.post(`board/${id}/edit`, form)
            .then(res => {
                // eslint-disable-next-line no-undef
                Toast.fire(`O Board foi alterado com sucesso.`, "", "success");
                return true;
            })
            .catch(error => {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },
}

export default actions;
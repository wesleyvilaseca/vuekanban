import { HttpAuth } from "@/config/axiosConfig";

const actions = {
    updateCard({ commit }, obj) {
        // Processa a api
        const endpoint = `card/${obj.id}/edit`;

        return HttpAuth.post(endpoint, obj)
            .then(res => {
                if (res.ok) {
                    commit('');
                    return true;
                }
            })
            .catch(error => {
                console.log(error);
            });
    },

    createAtv({ dispatch }, obj) {
        return HttpAuth.post('card', obj)
            .then(res => {
                dispatch('getBoard', obj.project_id)
            })
            .catch(error => {
                this.Toast.fire(error.message, "", "error");
            })
    },

    // Deleta um produto
    async deleteCard({ commit }, card) {
        return await HttpAuth.post(`/card/${card.id}/delete`)
            .then((res) => {
                commit('');
                // eslint-disable-next-line no-undef
                Toast.fire(`A atividade foi deletada com sucesso.`, "", "success");
                return true;
            })
            .catch(error => {
                // eslint-disable-next-line no-undef
                Toast.fire(error.message, "", "error");
            })
    },
}

export default actions;
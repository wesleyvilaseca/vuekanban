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
    }
}

export default actions;
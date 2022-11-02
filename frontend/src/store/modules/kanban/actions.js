import { HttpAuth } from "@/config/axiosConfig";

const actions = {
    getBoard({ commit }, projectid) {
        return HttpAuth.get(`board/${projectid}`)
            .then(res => {
                commit("SET_BOARD", res.data.data)
            })
    },
}

export default actions;
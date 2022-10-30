import axios from "axios";

const actions = {
    getBoard({ commit }) {
        return axios.get("board")
            .then(res => {
                commit("setBoard", res.data.data)
            })
    },
}

export default actions;
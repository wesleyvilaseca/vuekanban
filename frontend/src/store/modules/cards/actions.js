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
    }
}

export default actions;
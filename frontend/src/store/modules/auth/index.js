import { Http, HttpAuth } from "@/config/axiosConfig";

const TOKEN_NAME = 'sanctun';

export default {
    state: {
        me: {
            name: '',
            email: ''
        },
        authenticated: false
    },

    mutations: {
        SET_ME(state, me) {
            state.me = me

            state.authenticated = true;
        },

        SET_AUTHENTICATED(state, status) {
            state.authenticated = status;
        },

        LOGOUT(state) {
            state.me = {
                name: '',
                email: ''
            }

            state.authenticated = false;

        },

    },

    actions: {
        // register({ commit }, params) {
        //     return axios.post('auth/register', params);
        // },

        login({ commit }, params) {
            console.log(params);
            return Http.post('auth/token', params)
                .then((res) => {
                    // const token = res.data.token;
                    // localStorage.setItem(TOKEN_NAME, token);
                    commit('');
                    console.log(res);
                })
        },

        getMe({ commit }) {
            const token = localStorage.getItem(TOKEN_NAME);

            if (!token) return;

            return HttpAuth.get('auth/me', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
                .then((res) => {
                    commit('SET_ME', res.data.data)
                })
                .catch(error => {
                    localStorage.removeItem(TOKEN_NAME);
                    alert('operação não authorizada 1');
                    console.log(error)
                })
        },

        logout({ commit }) {
            const token = localStorage.getItem(TOKEN_NAME);

            if (!token) return;

            return HttpAuth.post('auth/logout', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
                .then((res) => {
                    localStorage.removeItem(TOKEN_NAME);
                    commit('LOGOUT');
                    this.$router.push({ name: 'home' });
                    console.log(res);

                })
                .catch(error => {
                    console.log(error);
                })
        }


    },
}
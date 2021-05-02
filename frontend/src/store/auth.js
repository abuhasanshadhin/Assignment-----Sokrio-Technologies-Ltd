export default {
    namespaced: true,

    state: () => ({
        user: null
    }),

    getters: {
        user: state => state.user
    },

    mutations: {
        setUser: (state, data) => state.user = data
    },

    actions: {
        async login(ctx, data) {
            let isSuccess = false;

            await window.axios.post('/login', data)
                .then((res) => {
                    isSuccess = true;
                    let token = res.data.access_token;
                    localStorage.setItem('access_token', token);
                    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                    ctx.commit('setUser', res.data.user);
                }).catch((err) => {
                    window.toast('error', err.response.data.message);
                });

            return isSuccess;
        },

        async checkAuth(ctx) {
            let isAuthenticated = false;

            await window.axios.get('/check-auth')
                .then(res => {
                    isAuthenticated = true;
                    ctx.commit('setUser', res.data.user);
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                });

            return isAuthenticated;
        },

        logout() {
            window.axios.get('/logout')
                .then(res => {
                    window.toast('success', res.data.message);
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                })
        }
    }
}
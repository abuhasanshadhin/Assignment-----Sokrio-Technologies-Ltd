export default {
    namespaced: true,

    state: () => ({
        users: []
    }),

    getters: {
        users: state => state.users
    },

    mutations: {
        setUsers: (state, users) => state.users = users
    },

    actions: {
        getUsers(ctx, filters) {
            let qs = filters ? '?' + new URLSearchParams(filters).toString() : '';
            window.axios.get(`/users${qs}`)
                .then(res => {
                    ctx.commit('setUsers', res.data.users);
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                });
        },

        async addUser(ctx, user) {
            let isSuccess = false;

            await window.axios.post('/users', user)
                .then(res => {
                    isSuccess = true;
                    window.toast('success', res.data.message);
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                });

            return isSuccess;
        },

        async updateUser(ctx, user) {
            let isSuccess = false;

            let userId = user.id;

            delete user.id;

            await window.axios.put(`/users/${userId}`, user)
                .then(res => {
                    isSuccess = true;
                    window.toast('success', res.data.message);
                    ctx.dispatch('getUsers', { branch_id: user.branch_id });
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                });

            return isSuccess;
        },

        async deleteUser(ctx, id) {
            let isSuccess = false;

            await window.axios.delete(`/users/${id}`)
                .then(res => {
                    isSuccess = true;
                    window.toast('success', res.data.message);
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                });

            return isSuccess;
        },
    }
}
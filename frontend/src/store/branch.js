export default {
    namespaced: true,

    state: () => ({
        branches: []
    }),

    getters: {
        branches: state => state.branches
    },

    mutations: {
        setBranches: (state, data) => state.branches = data
    },

    actions: {
        getBranches(ctx) {
            window.axios.get('/branches')
                .then(res => {
                    ctx.commit('setBranches', res.data.branches);
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                });
        },

        async addBranch(ctx, branch) {
            let isSuccess = false;

            await window.axios.post('/branches', branch)
                .then(res => {
                    isSuccess = true;
                    window.toast('success', res.data.message);
                    ctx.dispatch('getBranches');
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                });

            return isSuccess;
        },

        async updateBranch(ctx, branch) {
            let isSuccess = false;

            await window.axios.put(`/branches/${branch.id}`, {
                name: branch.name,
                address: branch.address
            })
                .then(res => {
                    isSuccess = true;
                    window.toast('success', res.data.message);
                    ctx.dispatch('getBranches');
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                });

            return isSuccess;
        },

        async deleteBranch(ctx, id) {
            let isSuccess = false;

            await window.axios.delete(`/branches/${id}`)
                .then(res => {
                    isSuccess = true;
                    window.toast('success', res.data.message);
                    ctx.dispatch('getBranches');
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                });

            return isSuccess;
        },
    }
}
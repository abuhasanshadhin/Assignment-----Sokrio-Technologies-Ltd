export default {
    namespaced: true,

    state: () => ({
        checkIn: false
    }),

    getters: {
        checkIn: state => state.checkIn
    },

    mutations: {
        setCheckInStatus: (state, status) => state.checkIn = status
    },

    actions: {
        receiveAttendance(ctx) {
            window.axios.get('/attendance/receive')
                .then(res => {
                    ctx.commit('setCheckInStatus', res.data.check_in);
                    window.toast('success', res.data.message)
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                });
        },

        async willCheckIn(ctx) {
            let checkIn = false;

            await window.axios.get('/will-check-in')
                .then(res => {
                    ctx.commit('setCheckInStatus', res.data.check_in);
                }).catch(err => {
                    window.toast('error', err.response.data.message);
                });

            return checkIn;
        }
    }
}
<template>
    <div>
        <div class="container">
            <div v-if="isAdmin" id="nav">
                <router-link to="/dashboard">Home</router-link>
                <router-link to="/branch">Branches</router-link>
                <router-link to="/employee">Employees</router-link>
                <router-link to="/">Attendences</router-link>
            </div>
            <div class="text-center my-3">
                <strong>
                    {{ $store.getters["auth/user"]?.branch?.name }} Branch
                </strong>
                | {{ $store.getters["auth/user"]?.name }} |
                <a href="#" @click.prevent="logout">Logout</a>
            </div>
            <router-view />
        </div>
    </div>
</template>

<script>
export default {
    name: "Layout",

    computed: {
        isAdmin() {
            let user = this.$store.getters["auth/user"];
            if (user) {
                return user.role == "admin";
            }

            return false;
        },
    },

    async created() {
        let isAuthenticated = await this.$store.dispatch("auth/checkAuth");

        if (!isAuthenticated) {
            localStorage.setItem("access_token", "");
            this.$router.push("/");
        }
    },

    methods: {
        logout() {
            this.$store.dispatch("auth/logout");
            localStorage.setItem("access_token", "");
            this.$router.push("/");
        },
    },
};
</script>

<style scoped>
#nav {
    text-align: center;
    margin: 20px 0 0;
}

#nav a {
    text-decoration: none;
    display: inline-block;
    padding: 0 20px;
    font-size: 20px;
}

#nav a.router-link-exact-active {
    font-weight: bold;
}
</style>

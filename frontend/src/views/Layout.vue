<template>
    <div>
        <div class="container">
            <div id="nav">
                <router-link to="/dashboard">Home</router-link>
                <router-link to="/branch">Branches</router-link>
                <router-link to="/employee">Employees</router-link>
                <router-link to="/">Attendences</router-link>
            </div>
            <div class="text-center mb-3">
                <strong>
                    {{ $store.getters["auth/user"]?.branch?.name }} Branch
                </strong>
                | {{ $store.getters["auth/user"].name }} |
                <a href="#" @click.prevent="logout">Logout</a>
            </div>
            <router-view />
        </div>
    </div>
</template>

<script>
export default {
    name: "Layout",

    methods: {
        logout() {
            this.$store.dispatch("auth/logout");

            localStorage.setItem("access_token", "");
            localStorage.setItem("c_user", "");

            this.$router.push("/");
        },
    },
};
</script>

<style scoped>
#nav {
    text-align: center;
    margin: 20px 0 15px;
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

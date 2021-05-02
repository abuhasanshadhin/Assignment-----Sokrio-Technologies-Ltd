<template>
    <router-view />
</template>

<script>
export default {
    name: "App",

    // mounted() {
    //     let token = localStorage.getItem("access_token");

    //     if (token && this.$route.path == "/") {
    //         this.$router.push("/dashboard");
    //     }
    // },
};
</script>

<style>
.page-heading {
    text-align: center;
    font-style: italic;
    border-bottom: 2px solid;
    padding-bottom: 15px;
    margin-bottom: 25px;
}
</style>
<template>
    <div class="">
        <div class="login-wrapper col-md-4">
            <div class="card">
                <div class="card-header">Login to Your Account</div>
                <div class="card-body">
                    <form @submit.prevent="handleLogin">
                        <div class="mb-2">
                            <label for="username" class="mb-1">Username</label>
                            <input
                                type="text"
                                v-model.trim="user.username"
                                class="form-control"
                                id="username"
                            />
                        </div>
                        <div class="mb-2">
                            <label for="password" class="mb-1">Password</label>
                            <input
                                type="password"
                                v-model.trim="user.password"
                                class="form-control"
                                id="password"
                            />
                        </div>
                        <div class="pt-1">
                            <input
                                type="submit"
                                value="Login"
                                :disabled="loading"
                                class="btn btn-primary me-2"
                            />
                            <input
                                type="reset"
                                @click.prevent="resetForm"
                                value="Reset"
                                :disabled="loading"
                                class="btn btn-secondary"
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",

    data() {
        return {
            user: {
                username: "",
                password: "",
            },

            loading: false,
        };
    },

    methods: {
        async handleLogin() {
            if (this.user.username == "") {
                window.toast("warning", "Username is required");
            } else if (this.user.password == "") {
                window.toast("warning", "Password is required");
            } else {
                this.loading = true;

                let res = await this.$store.dispatch("auth/login", this.user);
                if (res) {
                    this.resetForm();

                    let user = this.$store.getters["auth/user"];

                    if (user && user.role == "employee") {
                        this.$router.push("/attendance");
                    } else {
                        this.$router.push("/dashboard");
                    }
                }

                this.loading = false;
            }
        },

        resetForm() {
            this.user.username = "";
            this.user.password = "";
        },
    },
};
</script>

<style scoped>
.login-wrapper {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>

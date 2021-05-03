<template>
    <div>
        <h3 class="page-heading">Employees</h3>

        <div class="row">
            <div class="col-md-5">
                <form @submit.prevent="saveUserInfo" method="post">
                    <div class="mb-2 row">
                        <div class="col-md-6">
                            <label for="name" class="mb-1">Name</label>
                            <input
                                type="text"
                                v-model.trim="user.name"
                                class="form-control"
                                id="name"
                            />
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="mb-1">Username</label>
                            <input
                                type="text"
                                v-model.trim="user.username"
                                class="form-control"
                                id="username"
                            />
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="mb-1">E-Mail</label>
                        <input
                            type="email"
                            v-model.trim="user.email"
                            class="form-control"
                            id="email"
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
                    <div class="mb-2 row">
                        <div class="col-md-6">
                            <label for="role" class="mb-1">Role</label>
                            <select
                                v-model.trim="user.role"
                                id="role"
                                class="form-control"
                            >
                                <option value="manager">Manager</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="branch" class="mb-1">Branch</label>
                            <select
                                v-model.number="user.branch_id"
                                id="branch"
                                class="form-control"
                            >
                                <option
                                    v-for="(branch, i) in $store.getters[
                                        'branch/branches'
                                    ]"
                                    :key="i"
                                    :value="branch.id"
                                >
                                    {{ branch.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <input
                            type="submit"
                            value="Save"
                            :disabled="loading"
                            class="btn btn-primary me-2"
                        />
                        <input
                            type="reset"
                            value="Reset"
                            :disabled="loading"
                            class="btn btn-secondary"
                        />
                    </div>
                </form>
            </div>

            <div class="col-md-7">
                <div class="row mb-2">
                    <div class="col-md-2 text-center">
                        <label for="select-branch">Branch</label>
                    </div>
                    <div class="col-md-5">
                        <select
                            v-model="selectedBranch"
                            id="select-branch"
                            class="form-control form-control-sm"
                        >
                            <option
                                v-for="(branch, i) in $store.getters[
                                    'branch/branches'
                                ]"
                                :key="i"
                                :value="branch.id"
                            >
                                {{ branch.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>E-Mail</th>
                                <th>Role</th>
                                <th>Branch</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="users.length > 0">
                                <tr v-for="(user, index) in users" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.username }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.role }}</td>
                                    <td>{{ user.branch?.name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button
                                                @click.prevent="editUser(user)"
                                                class="btn btn-sm btn-info me-1"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                @click.prevent="
                                                    deleteUser(user.id)
                                                "
                                                class="btn btn-sm btn-danger"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="7">
                                        Select branch for Employees
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "User",

    data() {
        return {
            user: {
                name: "",
                username: "",
                email: "",
                password: "",
                role: "",
                branch_id: "",
            },

            userId: null,

            loading: false,
            selectedBranch: null,
        };
    },

    watch: {
        selectedBranch(id) {
            this.$store.dispatch("user/getUsers", { branch_id: id });
        },
    },

    computed: {
        users() {
            return this.$store.getters["user/users"];
        },
    },

    created() {
        this.$store.dispatch("branch/getBranches");
    },

    methods: {
        async saveUserInfo() {
            if (
                this.user.name == "" ||
                this.user.username == "" ||
                this.user.email == "" ||
                (this.userId == null && this.user.password == "") ||
                this.user.role == "" ||
                this.user.branch_id == ""
            ) {
                window.toast("warning", "All fields are required");
                return;
            }

            this.loading = true;

            let action = "user/addUser";
            let user = { ...this.user };

            if (this.userId != null) {
                action = "user/updateUser";
                user.id = this.userId;
            }

            let res = await this.$store.dispatch(action, user);

            if (res) {
                this.resetForm();
                this.$store.dispatch("user/getUsers", {
                    branch_id: this.selectedBranch,
                });
            }

            this.loading = false;
        },

        editUser(user) {
            this.userId = user.id;
            Object.keys(this.user).forEach((k) => (this.user[k] = user[k]));
        },

        async deleteUser(id) {
            if (!confirm("Are you sure?")) return;
            let res = await this.$store.dispatch("user/deleteUser", id);
            if (res) {
                this.$store.dispatch("user/getUsers", {
                    branch_id: this.selectedBranch,
                });
            }
        },

        resetForm() {
            this.userId = null;
            Object.keys(this.user).forEach((k) => (this.user[k] = ""));
        },
    },
};
</script>
<template>
    <div>
        <h3 class="page-heading">Branches</h3>

        <div class="row">
            <div class="col-md-5">
                <form @submit.prevent="saveBranchInfo" method="post">
                    <div class="mb-2">
                        <label for="name" class="mb-1">Branch Name</label>
                        <input
                            type="text"
                            v-model.trim="branch.name"
                            class="form-control"
                            id="name"
                        />
                    </div>
                    <div class="mb-2">
                        <label for="address" class="mb-1">Address</label>
                        <textarea
                            v-model.trim="branch.address"
                            id="address"
                            class="form-control"
                        ></textarea>
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
                <div class="table-responsive">
                    <table class="table table-sm text-center">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Employees</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(branch, index) in $store.getters[
                                    'branch/branches'
                                ]"
                                :key="index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ branch.name }}</td>
                                <td>{{ branch.address }}</td>
                                <td>{{ branch.total_users }}</td>
                                <td>
                                    <button
                                        @click.prevent="editBranch(branch)"
                                        class="btn btn-sm btn-info me-1"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click.prevent="deleteBranch(branch.id)"
                                        class="btn btn-sm btn-danger"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Branch",

    data() {
        return {
            branch: {
                name: "",
                address: "",
            },

            branchId: null,

            loading: false,
        };
    },

    created() {
        this.$store.dispatch("branch/getBranches");
    },

    methods: {
        async saveBranchInfo() {
            if (this.branch.name == "") {
                window.toast("warning", "Branch name field is required");
            } else {
                this.loading = true;

                let action = "branch/addBranch";
                let branch = { ...this.branch };

                if (this.branchId != null) {
                    action = "branch/updateBranch";
                    branch.id = this.branchId;
                }

                let res = await this.$store.dispatch(action, branch);

                if (res) this.resetForm();

                this.loading = false;
            }
        },

        editBranch(branch) {
            this.branchId = branch.id;
            this.branch.name = branch.name;
            this.branch.address = branch.address;
        },

        deleteBranch(id) {
            if (!confirm("Are you sure?")) return;
            this.$store.dispatch("branch/deleteBranch", id);
        },

        resetForm() {
            this.branchId = null;
            this.branch.name = "";
            this.branch.address = "";
        },
    },
};
</script>
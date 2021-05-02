<template>
    <div>
        <h3 class="page-heading">Attendance</h3>

        <div class="text-center">
            <button
                @click.prevent="receiveAttendance"
                class="btn btn-primary btn-lg me-3"
            >
                {{
                    $store.getters["attendance/checkIn"]
                        ? "Check In"
                        : "Check Out"
                }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Attendance",

    data() {
        return {};
    },

    created() {
        this.$store.dispatch("attendance/willCheckIn");
    },

    methods: {
        receiveAttendance() {
            this.$store.dispatch("attendance/receiveAttendance");
        },
    },
};
</script>
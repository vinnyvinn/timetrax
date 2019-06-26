<template>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a @click.prevent="checkin" class="btn btn-primary blue-salsa btn-circle btn-sm active attend">
                    {{ checkedIn ? 'Check Out' : 'Check In' }}
                </a>
            </div>
            <div class="panel-body">
                <table class=" table table-striped table-hover table-responsive-dataTable" id="attendance_table">
                    <thead>
                    <tr>
                        <th>Employee name</th>
                        <th>Check in</th>
                        <th>Check out</th>
                        <th>Day</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="attendance in attendances">
                        <td>{{ attendance.employee.user.name  }}</td>
                        <td>{{ attendance.time_in }}</td>
                        <td>{{ attendance.time_out ? attendance.time_out : 'Not Checked Out' }}</td>
                        <td>{{ attendance.day }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        ready() {
            this.$http.get('/attendance').then((response) => {
                return response.json();
            }).then(response => {
                this.attendances = response.data;
            }).catch((response) => {
                console.log(response);
            });
        },
        data() {
            return {
                attendances: [],
            }
        },
        methods: {
            attend() {
                this.$http.get('/attendance/checkin').then((response) => {
                    return response.json();
                }).then(response => {
                    this.attendances = response.data;
                }).catch((response) => {
                    console.log(response);
                });
            },

            checkin() {
                this.attend();

            }
        },

        computed: {
            checkedIn() {
                var is_checked_in = false;
                $.each(this.attendances, function(index, value) {
                    if (value.time_out == null) {
                        is_checked_in = true;
                    }
                });

                return is_checked_in;
            }
        }
    }
</script>

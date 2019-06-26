<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="employee_id">Choose employee</label>
                        </div>
                        <div class="col-sm-3">
                            <label for="start_date">From (date)</label>
                        </div>
                        <div class="col-sm-6">
                            <label for="end_date">To (date)</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <select name="employee" class="form-control">
                                <option value="name"></option>
                                <option v-for="row in employees" value="{{ row.id }}">{{ row.first_name + " " + row.last_name }}</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="start_date" id="start_date" class="form-control" />
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="end_date" id="end_date" class="form-control" />
                        </div>
                        <div class="col-sm-3">
                            <button class="btn btn-warning" @click="getOvertime(false)" id="filter">Search</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class=" table table-striped table-hover table-responsive-dataTable" id="overtime_table">
                        <thead>
                        <tr>
                            <th>Employee name</th>
                            <th>Special (HRS)</th>
                            <th>Standard (HRS)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="row in overtime">
                            <td>{{ row.first_name + " " + row.last_name  }}</td>
                            <td>{{ row.overtimes['standard'] }}</td>
                            <td>{{ row.overtimes['special'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        ready() {
            this.getEmployees();
            this.getOvertime(true);
        },
        data() {
            return {
                employees: [],
                overtime: []
            };
        },
        computed: {
            totalOvertime() {
                var amount = [];
                for (var key in this.overtime) {
                    var index = Object.keys(this.overtime).indexOf(key);
                    amount[index] = 0;
                    for (var i = 0; i < this.overtime[key].length; i++) {
                        amount[index] += this.overtime[key][i].total_earned;
                    }
                }

                return amount;
            }
        },
        methods: {
            getEmployees() {
                $.ajax({
                    url: '/overtime',
                    method: 'GET',
                    data: { fetch_employees: 0 },
                    success:(data) => {
                        this.employees = JSON.parse(data);
                    },
                    error: function() {
                        showAlert('error', 'Data fetch not successful, try reloading the page');
                    }
                });
            },
            getOvertime(first) {
                var start_date = $('input[name="start_date"]').val();
                var end_date = $('input[name="end_date"]').val();
                var employee = $('select[name="employee"]').val();

                $.ajax({
                    url: '/overtime',
                    method: 'GET',
                    data: { from: start_date, to: end_date, employee: employee },
                    success:(data) => {
                        if (! Array.isArray(data)) {
                            data = JSON.parse(data);
                        }
                        this.overtime = data;

                        if (this.overtime.length < 1 && !first) {
                            showAlert('info', 'Sorry, no attendance information was found.');
                        }
                    },
                    error: function() {
                        showAlert('error', 'Data fetch not successful');
                    }
                });
            }
        }
    }
    function showAlert(type, message) {
        $(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "9000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr[type](message);
        });

    }
</script>
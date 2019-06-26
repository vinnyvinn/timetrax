<template>
 <div class="container">
     <div class="panel panel-default">
         <div class="panel-body">
             <table class="table table-responsive" id="role_table">
                 <thead>
                  <tr>
                      <th>ID</th>
                      <th>Role</th>
                      <th></th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="role in roles">
                      <td>{{role.id}}</td>
                      <td>{{ role.role }}</td>
                      <td></td>
                  </tr>
                 </tbody>
             </table>
         </div>
     </div>
 </div>
</template>
<script>
    export default{
            ready() {
                this.$http.get('/role').then((response) => {
                    return response.json();
                }).then(response => {
                    this.roles = response.data;
                }).catch((response) => {
                    console.log(response);
                });
            },
            data(){
                return{
                    roles: []
                }
            }
        }
</script>
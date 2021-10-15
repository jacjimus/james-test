<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Employees</h3>

                <div class="card-tools">

                  <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"  @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add New
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>First name</th>
                      <th>Last name</th>
                      <th>Company</th>
                      <th>Email</th>
                      <th>Phone number</th>
                      <!-- <th>Photo</th> -->
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="employee in employees.data" :key="employee.id">

                      <td>{{employee.id}}</td>
                      <td>{{employee.first_name}}</td>
                      <td>{{employee.last_name}}</td>
                      <td>{{employee.company.name}}</td>
                      <td>{{employee.email}}</td>
                      <td>{{employee.phone_number}}</td>
                      <td>
                          <a href="#" @click="editModal(employee)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          /
                          <a href="#" @click="deleteEmployee(employee.id)">
                              <i class="fa fa-trash red"></i>
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
                <div class="card-footer">
                    <pagination :data="employees" @pagination-change-page="getResults"></pagination>
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Employee</h5>
                    <h5 class="modal-title" v-show="editmode">Update Employee Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateEmployee() : createEmployee()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>First name</label>
                            <input v-model="form.first_name" type="text" name="first_name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
                            <has-error :form="form" field="first_name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Last name</label>
                            <input v-model="form.last_name" type="text" name="last_name"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }">
                            <has-error :form="form" field="last_name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <select v-model="form.company_id" name="company_id"
                                   class="form-control select2" :class="{ 'is-invalid': form.errors.has('company_id') }">
                                    <option v-for="(ele, index) in companies " :value="index">{{ ele }}</option>
                            </select>
                            <has-error :form="form" field="company_id"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="email" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Phone number</label>
                            <input v-model="form.phone_number" type="text" name="phone_number"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('phone_number') }">
                            <has-error :form="form" field="phone_number"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </section>
</template>

<script>
    export default {
        data () {
            return {
                editmode: false,
                companies : {},
              employees : {},
              // Create a new form instance
              form: new Form({
                  id : '',
                  first_name: '',
                  last_name: '',
                  company: this.companies,
                  company_id: '',
                  email: '',
                  phone_number: '',
              })
            }
        },
        methods: {
            getResults(page = 1) {

                this.$Progress.start();

                axios.get('api/employee?page=' + page).then(({ data }) => (this.employees = data.data));

                this.$Progress.finish();
            },
            loadEmployees(){
                this.$Progress.start();

                axios.get("api/employee").then(({ data }) => (this.employees = data.data));

                this.$Progress.finish();
            },
            loadCompanies(){
                this.$Progress.start();

                axios.get("api/companies/list").then(({ data }) => (this.companies = data.data));

                this.$Progress.finish();
            },

          createEmployee(){
              this.$Progress.start();

              this.form.post('api/employee')
              .then((data)=>{
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadEmployees();

              })
              .catch(()=>{

                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
          },
            updateEmployee(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/employee/'+this.form.id)
                    .then((response) => {
                        // success
                        $('#addNew').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                        this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                        this.loadEmployees();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });

            },
            editModal(employee){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(employee);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteEmployee(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/employee/'+id).then((data)=>{
                            Swal.fire(
                                'Deleted!',
                                data.data.message,
                                'success'
                            );
                            // Fire.$emit('AfterCreate');
                            this.loadEmployees();
                        }).catch((data)=> {
                            Swal.fire("Failed!", data.message, "warning");
                        });
                    }
                })
            },

        },
        mounted() {

        },
        created() {
            this.$Progress.start();

            this.loadEmployees();

            this.loadCompanies();

            this.$Progress.finish();
        }
    }
</script>

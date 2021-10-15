<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Companies</h3>

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
                      <th>Name</th>
                      <th>Email</th>
                      <th>Logo</th>
                      <th>Website</th>
                      <!-- <th>Photo</th> -->
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="company in companies.data" :key="company.id">

                      <td>{{company.id}}</td>
                      <td>{{company.name}}</td>
                      <td>{{company.email}}</td>
                      <td>{{company.logo}}</td>
                      <td>{{ company.website }}</td>
                      <td>
                          <a href="#" @click="editModal(company)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          /
                          <a href="#" @click="deleteCompany(company.id)">
                              <i class="fa fa-trash red"></i>
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
                <div class="card-footer">
                    <pagination :data="companies" @pagination-change-page="getResults"></pagination>
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
                    <h5 class="modal-title" v-show="!editmode">Create New Company</h5>
                    <h5 class="modal-title" v-show="editmode">Update Company Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateCompany() : createCompany()" id="company-data" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="email" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group row">
                            <label>Logo</label>
                            <span class="col-md-5" v-if="form.logo">
                                <img :src="logo_url" class="img-responsive" height="100" width="100">
                            </span>
                            <span class="col-md-6">
                                <input type="file" name="logo"  class="form-control" @change="onLogoChange" :class="{ 'is-invalid': form.errors.has('logo') }">
                                <has-error :form="form" field="logo"></has-error>
                            </span>

                        </div>
                        <div class="form-group">
                            <label>Website</label>
                            <input v-model="form.website" type="url" name="website"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('website') }">
                            <has-error :form="form" field="website"></has-error>
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
              companies : {},
                editmode: false,
                logo_url : '',
              // Create a new form instance
              form: new Form({
                  id : '',
                  name: '',
                  email: '',
                  logo: '',
                  website: '',
              })
            }
        },
        methods: {
            getResults(page = 1) {

                this.$Progress.start();

                axios.get('api/company?page=' + page).then(({ data }) => (this.companies = data.data));

                this.$Progress.finish();
            },
          loadCompanies(){
            // if(this.$gate.isAdmin()){
              axios.get("api/company").then(({ data }) => (this.companies = data.data));
            // }
          },
        onLogoChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.form.logo  = files[0];
            this.logo_url = URL.createObjectURL(this.form.logo);

        },

          createCompany(e){
              this.$Progress.start();

              let form_data = new FormData();
              for (let item in this.form){
                  form_data.append(item, this.form[item]);
              }
              axios.post('api/company' , form_data)
              .then((data)=>{
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadCompanies();

              })
              .catch(()=>{

                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
          },
            updateCompany(){
                this.$Progress.start();
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                let form_data = new FormData();
                for (let item in this.form){
                    form_data.append(item, this.form[item]);
                }
                form_data.append('_method', 'PUT');

                axios.post(`api/company/${this.form.id}` , form_data, config )
                    .then((response) => {
                        // success
                        $('#addNew').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                        this.$Progress.finish();

                        this.loadCompanies();
                    })
                    .catch(() => {
                        //this.form.errors =  res.data.errors;
                        this.$Progress.fail();
                    });

            },
            editModal(company){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(company);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteCompany(id){
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
                        this.form.delete('api/company/'+id).then(()=>{
                            Swal.fire(
                                'Deleted!',
                                'Company has been deleted.',
                                'success'
                            );
                            // Fire.$emit('AfterCreate');
                            this.loadCompanies();
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

            this.loadCompanies();

            this.$Progress.finish();
        }
    }
</script>

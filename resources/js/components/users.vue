<template>
  <div class="profile-container">

    <div class="row">
      <h2>Users</h2>
      
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Display Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Created At</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(user, index) in users" :key="index">
            <td>
              <div v-if="user.role_name === 'Admin' || user.role_name === 'Administrator'">
                {{ user.fullname }}
              </div>
              <div v-else>
                <a href="#" @click="showUpdateModal(user)">{{ user.fullname }}</a>
              </div>
            </td>
            <td>{{ user.email }}</td>
            <td>{{ user.role_name }}</td>
            <td>{{ user.created_at }}</td>
          </tr>
        </tbody>
      </table>

    </div>

    <div class="float-right">
      <button type="button" href="#" @click="showModal" class="btn btn-light">Add User</button>
    </div>

    <b-modal ref="modal" hide-footer :title="title">
      <div class="container">

        <div class="row mb-2">
          <div class="col-md-3">
            Name
          </div>
          <div class="col-md-9">
            <input ref="name" type="text" v-model="user.fullname" class="form-control" />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-3">
             Email Address
          </div>
           <div class="col-md-9">
            <input ref="email" type="text" v-model="user.email" class="form-control" />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-3">
            Password
          </div>
           <div class="col-md-9">
            <input ref="password" v-model="user.password" type="password" class="form-control" />
          </div>
        </div>

        <div class="row mb-2">
           <div class="col-md-3">
             Role
          </div>
          <div class="col-md-9">
           
            <select ref="role" id="role" class="form-control" v-model="user.role_id">
              <option v-for="(role, index) in roles" :key="index" :value="role.id">
                  {{ role.name }}
              </option>
            </select>

          </div>
        </div>

       
          <div class="button-create-containter" v-if="mode === 'create'">
             <div class="float-right">
              <button type="button" href="#" @click="hideModal" class="btn btn-light">Cancel</button>
              <button type="button" href="#" @click="save" class="btn btn-light">Save</button>
             </div>
          </div>
          <div v-else-if="mode === 'update'">
            <b-button class="mt-2 float-left" variant="outline-danger" @click="deleteItem">Delete</b-button>
            <div class="float-right">
              <b-button class="mt-2" variant="outline-primary" @click="hideModal">Cancel</b-button>
              <b-button class="mt-2" variant="outline-primary" @click="update">Update</b-button>
            </div>
          </div>
      </div>
     

    </b-modal>


  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
      roles: [],
      mode: "",
      user: {
        user_id: "",
        role_id: "",
        fullname: "",
        email: "",
        password: "",
        role_name: ""
      }

    };
  },
  methods: {
    showModal() {
      this.user.user_id = "";
      this.user.role_id = "";
      this.user.fullname = "";
      this.user.email = "";
      this.user.password = "";

      this.mode = "create"
      this.title = "Add User";
      this.$refs["modal"].show();
    },
    showUpdateModal(data) {
      this.mode = "update";
      this.user.user_id = data.user_id;
      this.user.role_id = data.role_id;
      this.user.fullname = data.fullname;
      this.user.email = data.email;
      this.user.password = data.password;
    
    this.title = "Update User";
      this.$refs["modal"].show();
    },
    hideModal() {
      this.$refs["modal"].hide();
    },
    save() {
      axios.post(`http://localhost:8000/api/add_user`, this.user)
      .then(response => {
        this.users = response.data.users;
         this.hideModal();
      })
      .catch(e => {
        this.errors.push(e)
      });
     
    },
    deleteItem() {

      axios
        .post("http://localhost:8000/api/user/delete", { user: this.user, _method: "delete" })
        .then(response => {
          this.users = response.data.users;
        })
        .catch(function(error) {
          this.errors.push(e)
        });

        this.hideModal();

    },
    update(user) {
      
      axios.post("http://localhost:8000/api/user/update", { user: this.user, _method: "patch" })
        .then(response => {
            this.users = response.data.users;
        })
        .catch(e => {
          this.errors.push(e)
        });
        this.hideModal();
    }

  },
  mounted() {
    axios
      .get("http://localhost:8000/api/users")
      .then(response => {
        this.users = response.data.users;
       
      });

    axios
      .get("http://localhost:8000/api/roles")
      .then(response => {
        this.roles = response.data.roles;
        console.log(response.data.roles)
      });

  }
};
</script>

<style scoped>
</style>
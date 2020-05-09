<template>
  <div class="profile-container">

    <div class="row">
      <h2>Roles</h2>
      
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Display Name</th>
            <th scope="col">Description</th>
            <th scope="col">Created At</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(role, index) in roles" :key="index">
            <td>
              <div v-if="role.name === 'Admin' || role.name === 'Administrator'">{{ role.name }}</div>
              <div v-else>
                <a href="#" @click="showUpdateModal(role)">{{ role.name }}</a>
              </div>
            </td>
            <td>{{ role.description }}</td>
            <td>{{ role.created_at }}</td>
          </tr>
        </tbody>
      </table>

    </div>

    <div class="float-right">
      <button type="button" href="#" @click="showModal" class="btn btn-light">Add Role</button>
    </div>

    <b-modal ref="modal" hide-footer :title="title">
      <div class="container">

        <div class="row mb-2">
          <div class="col-md-3">
            Display Name
          </div>
          <div class="col-md-9">
            <input ref="name" type="text" v-model="role.name" class="form-control" />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-3">
             Description
          </div>
           <div class="col-md-9">
            <input ref="description" type="text" v-model="role.description" class="form-control" />
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
      title: "",
      role: {
        id: "",
        name: "",
        description: ""
      }

    };
  },
  methods: {
    showModal() {
      this.role.id = "";
      this.role.name = "";
      this.role.description = "";

      this.mode = "create"
      this.title = "Add Role";
      this.$refs["modal"].show();
    },
    showUpdateModal(data) {
      this.mode = "update";
      this.title = "Update Role";

      this.role.id = data.id;
      this.role.name = data.name;
      this.role.description = data.description;
    
      this.$refs["modal"].show();
    },
    hideModal() {
      this.$refs["modal"].hide();
    },
    save() {
      axios.post(`http://localhost:8000/api/add_role`, this.role)
      .then(response => {
        this.roles = response.data.roles;
        this.hideModal();
      })
      .catch(e => {
        this.errors.push(e)
      });
     
    },
    deleteItem() {

      axios
        .post("http://localhost:8000/api/role/delete", { role: this.role, _method: "delete" })
        .then(response => {
          this.roles = response.data.roles;
        })
        .catch(function(error) {
          this.errors.push(e)
        });

        this.hideModal();

    },
    update(user) {
      
      axios.post("http://localhost:8000/api/role/update", { role: this.role, _method: "patch" })
        .then(response => {
            this.roles = response.data.roles;
        })
        .catch(e => {
          this.errors.push(e)
        });
        this.hideModal();
    }

  },
  mounted() {


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
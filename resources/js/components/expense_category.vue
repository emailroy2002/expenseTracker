<template>
  <div class="profile-container">

    <div class="row">
      <h2>Expense Categories</h2>
      
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Display Name</th>
            <th scope="col">Description</th>
            <th scope="col">Created At</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(expense_category, index) in expense_categories" :key="index">
            <td>
              <a href="#" @click="showUpdateModal(expense_category)">{{ expense_category.name }}</a>
            </td>
            <td>{{ expense_category.description }}</td>
            <td>{{ expense_category.created_at }}</td>
          </tr>
        </tbody>
      </table>

    </div>

    <div class="float-right">
      <button type="button" href="#" @click="showModal" class="btn btn-light">Add Expense Category</button>
    </div>

    <b-modal ref="modal" hide-footer :title="title">
      <div class="container">

        <div class="row mb-2">
          <div class="col-md-3">
            Display Name
          </div>
          <div class="col-md-9">
            <input ref="name" type="text" v-model="expense_category.name" class="form-control" />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-3">
             Description
          </div>
           <div class="col-md-9">
            <input ref="description" type="text" v-model="expense_category.description" class="form-control" />
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
      expense_categories: [],
      mode: "",
      title: "",
      expense_category: {
        id: "",
        name: "",
        description: ""
      }

    };
  },
  methods: {
    showModal() {
      this.expense_category.id = "";
      this.expense_category.name = "";
      this.expense_category.description = "";

      this.mode = "create"
      this.title = "Add Expense Category";
      this.$refs["modal"].show();
    },
    showUpdateModal(data) {
      this.mode = "update";
      this.title = "Update Expense Category";

      this.expense_category.id = data.id;
      this.expense_category.name = data.name;
      this.expense_category.description = data.description;
    
      this.$refs["modal"].show();
    },
    hideModal() {
      this.$refs["modal"].hide();
    },
    save() {
      axios.post(`http://localhost:8000/api/add_expense_category`, this.expense_category)
      .then(response => {
        this.expense_categories = response.data.expense_categories;
        this.hideModal();
      })
      .catch(e => {
        this.errors.push(e)
      });
     
    },
    deleteItem() {

      axios
        .post("http://localhost:8000/api/expense_category/delete", { expense_category: this.expense_category, _method: "delete" })
        .then(response => {
          this.expense_categories = response.data.expense_categories;
        })
        .catch(function(error) {
          this.errors.push(e)
        });

        this.hideModal();

    },
    update(user) {
      
      axios.post("http://localhost:8000/api/expense_category/update", { expense_category: this.expense_category, _method: "patch" })
        .then(response => {
            this.expense_categories = response.data.expense_categories;
        })
        .catch(e => {
          this.errors.push(e)
        });
        this.hideModal();
    }

  },
  mounted() {


    axios
      .get("http://localhost:8000/api/expense_categories")
      .then(response => {
        this.expense_categories = response.data.expense_categories;
        console.log(response.data.expense_categories)
      });

  }
};
</script>

<style scoped>
</style>
<template>
  <div class="profile-container">

    <div class="row">
      <h2>Expenses</h2>
      
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Expenses Category</th>
            <th scope="col">Amount</th>
            <th scope="col">Entry Date</th>
            <th scope="col">Created At</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(expense, index) in expenses" :key="index">
            <td>
                <a href="#" @click="showUpdateModal(expense)">{{ expense.expense_category_name }}</a>
            </td>
            <td>{{ expense.amount }}</td>
            <td>{{ expense.entry_date }}</td>
            <td>{{ expense.created_at }}</td>
          </tr>
        </tbody>
      </table>

    </div>

    <div class="float-right">
      <button type="button" href="#" @click="showModal" class="btn btn-light">Add Expenses</button>
    </div>

    <b-modal ref="modal" hide-footer :title="title">
      <div class="container">


          <div class="row mb-2">
            <div class="col-md-3">
              Category
            </div>
            <div class="col-md-9">

              <select ref="expense_categories" id="expense_categories" class="form-control" v-model="expense.expense_category_id">
                <option v-for="(expense_category, index) in expense_categories" :key="index" :value="expense_category.id">
                    {{ expense_category.name }}
                </option>
              </select>


            </div>
          </div>



  
          <div class="row mb-2">
            <div class="col-md-3">
              Amount
            </div>
            <div class="col-md-9">
              <input ref="Amount" v-model="expense.amount" type="text" class="form-control" />
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
      expenses: [],
      mode: "",
      title: "",
      expense: {
        id: "",
        expense_category_id: "",
        name: "",
        description: ""
      }

    };
  },
  methods: {
    showModal() {
      this.expense.expense_category_id = "";
      this.expense.name = "";
      this.expense.description = "";
      this.expense.expense_category_id =  "";
      this.expense.amount = "";

      this.mode = "create"
      this.title = "Add Expenses";
      this.$refs["modal"].show();
    },
    showUpdateModal(data) {
      this.mode = "update";
      this.title = "Update Expenses";

      this.expense.id = data.id;
      this.expense.expense_category_id =  data.expense_category_id;
      this.expense.name = data.name;
      this.expense.amount = data.amount;
      this.expense.description = data.description;
    
      this.$refs["modal"].show();
    },
    hideModal() {
      this.$refs["modal"].hide();
    },
    save() {
      axios.post(`http://localhost:8000/api/add_expense`, this.expense)
      .then(response => {
        this.expenses = response.data.expenses;
        this.hideModal();
      })
      .catch(e => {
        this.errors.push(e)
      });
     
    },
    deleteItem() {

      axios
        .post("http://localhost:8000/api/expense/delete", { expense: this.expense, _method: "delete" })
        .then(response => {
          this.expenses = response.data.expenses;
        })
        .catch(function(error) {
          this.errors.push(e)
        });

        this.hideModal();

    },
    update(user) {
      
      axios.post("http://localhost:8000/api/expense/update", { expense: this.expense, _method: "patch" })
        .then(response => {
            this.expenses = response.data.expenses;
        })
        .catch(e => {
          this.errors.push(e)
        });
        this.hideModal();
    }

  },
  mounted() {
    axios
      .get("http://localhost:8000/api/expenses")
      .then(response => {
        this.expenses = response.data.expenses;
        console.log(response.data.roles)
      });
      
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
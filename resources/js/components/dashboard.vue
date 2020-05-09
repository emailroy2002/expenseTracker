<template>
  <div class="profile-container">

    <div class="row">
       <div class="col-md-12 py-3">
            <h4 class="float-left">My Expenses</h4>
            <h4 class="float-right">Dashboard</h4>
        </div>
    </div>


    <div class="row">
        <div class="container">

          


          <div class="row">
            <div class="col-md-6">
              <table class="table">
                <thead class="thead">
                <tr>
                  <th scope="col"><h4>Expense Category</h4></th>
                  <th scope="col"><h4>Total</h4></th>
                </tr>
                </thead>

                <tbody>
                  <tr v-for="(expense, index) in expenses" :key="index">

                  <td>{{ expense.expense_category_name }}</td>
                  <td>{{ expense.amount }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-6">
                <pie-chart :data="expense_summary"></pie-chart>
            </div>
          </div>
        </div>

        

       
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      expenses: [],
     
    };
  },
 mounted() {
    axios
      .get("http://localhost:8000/api/expense_summary")
      .then(response => {
        this.expense_summary = JSON.parse(JSON.stringify(response.data.expenses));
      });

     axios
      .get("http://localhost:8000/api/expenses")
      .then(response => {
        this.expenses = response.data.expenses;
        console.log(response.data.roles)
      });
      
  }
};
</script>

<style scoped>
</style>
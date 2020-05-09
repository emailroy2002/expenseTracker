import VueRouter from "vue-router";
Vue.use(VueRouter);



const routes = [   
    { 
        path: "/", 
        name: "dashboard", 
        component: require("./components/dashboard.vue").default,
    },
    { 
        path: "/users", 
        name: "users", 
        component: require("./components/users.vue").default, 
    },
    {   
        path: "/roles", 
        name: "roles", 
        component: require("./components/roles.vue").default, 
    },
    {   
        path: "/expense_category", 
        name: "expense_category", 
        component: require("./components/expense_category.vue").default, 
    },
    {   
        path: "/expenses", 
        name: "expenses", 
        component: require("./components/expenses.vue").default, 
    }
];

window.router = new VueRouter({
    routes: routes,
    //mode: "history"
    mode: "hash"
   
});
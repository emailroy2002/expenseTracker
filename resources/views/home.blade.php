@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <aside class="col-sm-3">
            <div class="card">
                <div class="list-group-item">
                    <router-link to="/">Dashboard</router-link>
                </div>

                <article class="card-group-item">
                    <header class="card-header"><h6 class="title">User Management </h6></header>
                    <div class="filter-content">
                        <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <router-link to="/roles">Roles</router-link>
                        </div>
                        <div class="list-group-item">
                            <router-link to="/users">Users</router-link>
                        </div>
                        </div>  <!-- list-group .// -->
                    </div>
                </article> <!-- card-group-item.// -->

                <article class="card-group-item">
                    <header class="card-header"><h6 class="title ">Expense Management</h6></header>
                    <div class="filter-content">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <router-link to="/expense_category">Expense Category</router-link>
                            </div>
                            <div class="list-group-item">
                                <router-link to="/expenses">Expenses</router-link>
                            </div>
                        </div>  <!-- list-group .// -->
                    </div>
                </article> <!-- card-group-item.// -->
            </div> <!-- card.// -->
        </aside>

        <div class="col-md-9">
            <div class="card mb-2">
                <div class="card-body">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
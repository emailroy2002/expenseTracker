<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

use App\User;
use App\Models\Role;
use App\Models\ExpenseCategory;
use App\Models\Expenses;
use App\Models\Photo;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Summary*/

Route::get('/expense_summary', function (Request $request) {
    $expenses = Expenses::get_expense_summary();

    foreach ($expenses as $expense) {
        $data[$expense['expense_category_name']] = $expense['amount'];
    }
    return Response()->json([
        "expenses" => $data
    ]);
});



/*Expenses*/

Route::get('/expenses', function (Request $request) {
    $expenses = Expenses::get_all_expenses();
    return Response()->json([
        "success" => true,
        "expenses" => $expenses
    ]);
});

Route::post('/add_expense', function (Request $request) {
    $data = Expenses::create([
        'expense_category_id' => $request->expense_category_id,
        'amount' => $request->amount,
        'entry_date'=> now(),
    ]);

    $expenses = Expenses::get_all_expenses();
    return Response()->json([
        "success" => true,
        "expenses" => $expenses
    ]);
});

Route::patch('/expense/update', function (Request $request) {
    $expense = Expenses::find($request->expense['id']);
    $expense->expense_category_id = $request->expense['expense_category_id'];
    $expense->amount = $request->expense['amount'];
    $expense->save();

    $expenses = Expenses::get_all_expenses();
    return Response()->json([
        "success" => true,
        "expenses" => $expenses
    ]);
});


Route::delete('/expense/delete', function (Request $request) {
    $expense = Expenses::find($request->expense['id']);
    $expense->delete();

    $expenses = Expenses::get_all_expenses();
    return Response()->json([
        "success" => true,
        "expenses" => $expenses
    ]);
});





/* Expense Category*/
Route::get('/expense_categories', function (Request $request) {
    $expense_categories = ExpenseCategory::get();
    return Response()->json([
        "success" => true,
        "expense_categories" => $expense_categories
    ]);
});

Route::post('/add_expense_category', function (Request $request) {
    $data = ExpenseCategory::create([
        'name' => $request->name,
        'description' => $request->description
    ]);

    $expense_categories = ExpenseCategory::get();
    return Response()->json([
        "success" => true,
        "expense_categories" => $expense_categories
    ]);
});

Route::patch('/expense_category/update', function (Request $request) {
    $expense_category = ExpenseCategory::find($request->expense_category['id']);
    $expense_category->name = $request->expense_category['name'];
    $expense_category->description = $request->expense_category['description'];
    $expense_category->save();

    $expense_categories = ExpenseCategory::get();
    return Response()->json([
        "success" => true,
        "expense_categories" => $expense_categories
    ]);
});

Route::delete('/expense_category/delete', function (Request $request) {
    $expense_category = ExpenseCategory::find($request->expense_category['id']);
    $expense_category->delete();

    $expense_categories = ExpenseCategory::get();
    return Response()->json([
        "success" => true,
        "expense_categories" => $expense_categories
    ]);
});


/*Roles*/
Route::get('/roles', function (Request $request) {
    $roles = DB::table('roles')->get();
    return Response()->json([
        "success" => true,
        "roles" => $roles
    ]);
});

Route::post('/add_role', function (Request $request) {
    $data = Role::create([
        'name' => $request->name,
        'description' => $request->description
    ]);

    $roles = DB::table('roles')->get();
    return Response()->json([
        "success" => true,
        "roles" => $roles
    ]);
});

Route::patch('/role/update', function (Request $request) {
    $role = Role::find($request->role['id']);
    $role->name = $request->role['name'];
    $role->description = $request->role['description'];
    $role->save();
    $roles = DB::table('roles')->get();
    return Response()->json([
        "success" => true,
        "roles" => $roles
    ]);
});


Route::delete('/role/delete', function (Request $request) {
    $role = Role::find($request->role['id']);
    $role->delete();
    $roles = DB::table('roles')->get();
    return Response()->json([
        "success" => true,
        "roles" => $roles
    ]);
});



/* start user api */
Route::get('/users', function (Request $request) {
    $users = User::get_all_users();
    return Response()->json([
        "success" => true,
        "users" => $users
    ]);
});

Route::post('/add_user', function (Request $request) {
    $data = User::create([
        'role_id' => $request->role_id,
        'fullname' => $request->fullname,
        'email' => $request->email,
        'password' => $request->password,
    ]);
    $users = User::get_all_users();
    return Response()->json([
        "success" => true,
        "users" => $users
    ]);
});

Route::patch('/user/update', function (Request $request) {
    $user = User::find($request->user['user_id']);
    $user->fullname = $request->user['fullname'];
    $user->email = $request->user['email'];
    $user->password = $request->user['password'];
    $user->role_id = $request->user['role_id'];
    $user->save();
    $users = User::get_all_users();
    return Response()->json([
        "success" => true,
        "users" => $users
    ]);
});

Route::delete('/user/delete', function (Request $request) {
    $user = User::find($request->user['user_id']);
    $user->delete();
    $users = User::get_all_users();
    return Response()->json([
        "success" => true,
        "users" => $users
    ]);
});




//Public User PROFILE = http://localhost/{username}
Route::get('/public/user', function (Request $request) {
    $user = User::where('username', $request->get('username'))->first();

    if (User::find($user->id)->photos->where('is_primary', true)->count() >= 1) {
        $user["primary_photo"] =  User::find($user->id)->photos->where('is_primary', true)->first();
        $user['education'] = User::find($user->id)->education->all();
        $user['experience'] = User::find($user->id)->experience->all();
        return $user;
    } else {
        $guest = User::where('username', 'default')->first();
        $user["primary_photo"] = User::find($guest->id)->photos->where('is_primary', true)->first();
        return $user;
    }
});

//Authenticated Routes - THIS ROUTE IS FOR YOUR LOGGED IN PROFIILE
Route::middleware('auth:api')->get('/user', function (Request $request) {
    $user = $request->user();

    if (User::find($user->id)->photos->where('is_primary', true)->count() >= 1) {
        $user["primary_photo"] =  User::find($user->id)->photos->where('is_primary', true)->first();
        $user['education'] = User::find($user->id)->education->all();
        $user['experience'] = User::find($user->id)->experience->all();
    } else {
        $guest = User::where('username', 'default')->first();
        $user["primary_photo"] = User::find($guest->id)->photos->where('is_primary', true)->first();
    }
    return $user;
});


/*POST*/
Route::middleware('auth:api')->post('/education', function (Request $request) {
});


/************************* [START] EXPERIENCE *************************/
Route::middleware('auth:api')->resource('/experience', 'ExperienceController');

/*
Route::middleware('auth:api')->post('/experience', function (Request $request) {
    $data = Experience::create([
        'user_id' => $request->user_id,
        'position' => $request->position,
        'company' => $request->company,
        'description' => $request->description,
        'yearStarted' => $request->yearStarted,
        'yearEnded' => $request->yearEnded
    ]);
    return Response()->json([
        "success" => true,
        "experience" => $data
    ]);
});


Route::middleware('auth:api')->patch('/experience/update', function (Request $request) {
    $user = User::find($request->user_id)->experience->find($request->experience['id']);
    $user->company = $request->experience['company'];
    $user->position = $request->experience['position'];
    $user->description = $request->experience['description'];
    $user->yearStarted = $request->experience['yearStarted'];
    $user->yearEnded = $request->experience['yearEnded'];
    $user->save();
    return $user;
});

Route::middleware('auth:api')->delete('/experience/delete', function (Request $request) {
    $user = User::find($request->user_id)->experience->find($request->experience['id'])->delete();
});

/************************* [END] EXPERIENCE *************************/




/************************* FRIEND API *************************/
Route::middleware('auth:api')->get('/friends', function (Request $request, User $user) {
    $friends = $request->user()->friends;

    $guest = User::where('username', 'default')->first();


    $defaultPhotoObject = User::find($guest->id)->photos->where('is_primary', true)->first();

    foreach ($friends as $key => $friend) {
        if (User::find($friend->id)->photos->where('is_primary', true)->count() >= 1) {
            $primaryPhoto = User::find($friend->id)->photos->where('is_primary', true)->first();


            /*if you have additonal path change the public path here */
            if (File::exists(public_path($primaryPhoto->filename))) {
                //'File exists');
                $friends[$key]['primary_photo'] =  $primaryPhoto;
            } else {
                //default is blank or empty
                $friends[$key]['primary_photo'] = $defaultPhotoObject;         
            }
        } else {
            $friends[$key]["primary_photo"] =  $defaultPhotoObject;
        }
        $friends[$key]['photos'] = User::find($friend->id)->photos->where('is_primary', false);
    }    
    return $friends;
});



Route::middleware('auth:api')->get('/test_friends', function (Request $request, User $user) {
    $friends = $request->user()->friends;
    foreach ($friends as $key => $friend) {
        $friends[$key]['primary_photo'] = User::find($friend->id)->photos->where('is_primary', true)->first();
        $friends[$key]['photos'] = User::find($friend->id)->photos->where('is_primary', false);
    }
    print_r(json_decode(json_encode($friends)));
});
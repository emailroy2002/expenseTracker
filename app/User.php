<?php

namespace App;

use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'id', 'fullname', 'email', 'password', 'api_token', 'role_id', 'status', 'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'create_at' => 'datetime'
    ];

    public static function get_all_users() {
        return User::join('roles', 'users.role_id', '=', 'roles.id')
        ->select('users.id as user_id', 'users.fullname', 'users.email', 'users.created_at', 'roles.name as role_name', 'roles.id as role_id')
        ->get();
    }
 
    public function photos()
    {
        return $this->hasMany('App\Models\Photo', 'user_id');
    }

    public static function primaryPhoto()
    {
        $user = User::where('email', Auth::user()->email)->first();

        if (User::find($user->id)->photos->where('is_primary', true)->count() >= 1) {
           return User::find($user->id)->photos->where('is_primary', true)->first();
        } 
    }


}

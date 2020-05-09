<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 
     * php artisan db:seed --class=UsersTableSeeder
     * 
     */
    
    public function run()
    {

        DB::table('roles')->insert([
            'id'   => 1,
            'name' => "Admin",
            'description'  => "Super User",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'id'   => 2,
            'name' => "User",
            'description'  => "Can Add Expenses",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'role_id'   => 1,
            'fullname' => "Roy",
            'email' => "emailroy2002@yahoo.com",
            'email_verified_at' => now(),         
            'password' => bcrypt("lyrics1234"),
            'api_token' => Str::random(50),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        /*
        
        $user = App\User::create([
            'firstname' => "Default",
            'lastname'	=> "User",
            'username'	=> "default",
            'email' => "default@default.com",
            'email_verified_at' => now(),         
            'password' => bcrypt("lyrics1234"),
            'status' => 1,
            'api_token' => Str::random(50),
            'remember_token' => Str::random(10),
        ]);

        

        App\Models\Photo::create([
            'user_id' => $user->id,
            'album_id' => 1,
            'filename' => "storage/images/photos/blank.jpg",
            'thumbnail'	=> "storage/images/photos/thumb.jpg",
            'is_primary' => 1,
            'url' => 'http://',
            'cdn_url' => 'htpp://',
            'privacy_id' => 1

        ]);        
                
        factory(App\User::class, 50)->create()->each(function($user) {
            //factory(App\User::class)->create();

            DB::table('friends')->insert([
                'user_id' => 1,
                'friend_user_id' => $user->id,
                'status_id' => 1
            ]);

        }); */
    }
}

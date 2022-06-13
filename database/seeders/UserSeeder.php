<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = "admin";
        $user->email = "admin@gmail.com";
        $user->password = HASH::make("12345678");
        $user->save();
        $user->roles()->attach(1);

        $roles = new Role();
        $roles->name = "admin";
        $roles->save();

        $roles = new Role();
        $roles->name = "user";
        $roles->save();


        for ($c = 1 ; $c < 10 ; $c ++ ){
            $cats = new Category();
            $cats->name = 'Category_'.$c;
            $cats->user_id = 1;
            $cats->save();
        }

    }
}

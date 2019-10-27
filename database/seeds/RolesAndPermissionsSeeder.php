<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\user;


class RolesAndPermissionsSeeder extends Seeder
{


    public function run()
{
    //




    // Reset cached roles and permissions
    app()['cache']->forget('spatie.permission.cache');


    Role::create(['name' => 'user']);
    Role::create(['name' => 'city_admin']);

  $a=  Role::create(['name' => 'super_admin']);


    $admin = user::create([
        'first_name'=>'munther',
        'last_name'=>"hejazi",
        'gender'=>'0',
        'cities_id'=>'1',
        'email'=>'lil@lili.com',
        'password'=>bcrypt('123456')
    ]);
    $admin->assignRole($a);



}
}

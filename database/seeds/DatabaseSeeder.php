<?php

use Illuminate\Database\Seeder;
use App\Cities;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Cities::create(['name' => 'Benghazi']);

        $this->call('RolesAndPermissionsSeeder');


    }
}

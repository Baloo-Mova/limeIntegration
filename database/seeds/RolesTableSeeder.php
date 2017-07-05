<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Role::find(1) == null){
            Role::Insert([
                ['title'     => 'User',],
                ['title'     => 'Admin',],
                ['title'     => 'Operator',],

            ]);
        }
    }
}

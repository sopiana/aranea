<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Model\UserManagement\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $roles = json_decode(File::get('database/dump/roles.json'));
        foreach($roles as $role)
        {
            Role::create(array(
                'description'=>$role->description,
                /*lets say that only around 80% of roles have description*/
                'note'=>rand(0,100)<80?$faker->sentence(20):null
            ));
        }
    }
}

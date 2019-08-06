<?php

use Illuminate\Database\Seeder;
use App\Model\RoleRight;

class RoleRightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $role_rights = json_decode(File::get('database/dump/role_rights.json'));
       foreach($role_rights as $role_right)
       {
           RoleRight::create(array(
               'role_id'=>$role_right->role_id,
               'right_id'=>$role_right->right_id
           ));
       }
    }
}

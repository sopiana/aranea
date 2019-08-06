<?php

use Illuminate\Database\Seeder;
use App\Model\UserManagement\Right;
class RightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rights = json_decode(File::get('database/dump/rights.json'));
        foreach($rights as $right)
        {
            Right::create(array(
                'key'=>$right->key,
                'description'=>$right->description
            ));
        }
    }
}

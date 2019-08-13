<?php
use App\Model\UserManagement\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Database\QueryException;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        //lets say that we have 500 users
        for($i=0;$i<500;$i++)
        {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $role_id = 0;
            $rand = rand(0,100);
            if($i==0)
                $role_id = 1;   //This is admin
            elseif($rand<5)     //lets say we have 5% is Scrum Master
                $role_id = 2;
            elseif($rand<10)    //lets say we have 5% is Product Owner
                $role_id = 3;
            elseif ($rand<15)  //lets say we have 5% is Development Leader
                $role_id = 4;
            elseif ($rand<20)  //lets say we have 5% is Test Leader
                $role_id = 7;
            elseif ($rand<50)  //lets say we have 30% is Developer
                $role_id = 6;
            elseif ($rand<80)  //lets say we have 30% is Tester
                $role_id = 9;
            elseif ($rand<85)  //lets say we have 5% is Software Architect
                $role_id = 5;
            elseif ($rand<90)  //lets say we have 5% is Test Architect
                $role_id = 8;
            else
                $role_id = 10;
            User::create(array(
                    'username'=>$firstName.substr($lastName,0,4),
                    'email'=>strtolower($firstName.'.'.$lastName).'@foo.com',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'avatar'=>'assets/images/avatars/users/'.strval(rand(1,70)).'.png',
                    'first_name'=>$firstName,
                    'last_name'=>$lastName,
                    'company'=>'foo.com',
                    'role_id'=>$role_id,
                    'phone'=>rand(0,100)<70?$faker->phoneNumber():null,
                    'mobile'=>rand(0,100)<50?$faker->phoneNumber():null,
                    'is_active'=>rand(0,100)<95,
                    'comment'=>rand(0,100)<60?$faker->paragraph():null
                ));
        }
    }
}

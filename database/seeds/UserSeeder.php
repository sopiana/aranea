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
            User::create(array(
                    'username'=>$firstName.substr($lastName,0,4),
                    'email'=>strtolower($firstName.'.'.$lastName).'@foo.com',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'avatar'=>'assets/images/avatar1.png',
                    'first_name'=>$firstName,
                    'last_name'=>$lastName,
                    'company'=>'foo.com',
                    'phone'=>rand(0,100)<70?$faker->phoneNumber():null,
                    'mobile'=>rand(0,100)<50?$faker->phoneNumber():null,
                    'is_active'=>rand(0,100)<95,
                    'comment'=>rand(0,100)<60?$faker->paragraph():null
                ));
        }
    }
}

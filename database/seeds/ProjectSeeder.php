<?php

use Illuminate\Database\Seeder;
use App\Model\ProjectManagement\Project;
use App\Model\ProjectManagement\ProjectKind;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $product_owners = DB::table('users')->select('id')->where('role_id','=','3')->get();
        $kind_num = ProjectKind::count();
        //lets say we already have 2000 projects
        for($i=0;$i<2000;$i++)
        {
            if($i%200==0)
                $this->command->info('Project seeds: '.$i.' items out of 2000');
            $dueDate = rand(1300191854,1565191854);
            $duration = rand(7776000,15552000);
            $createdDate = $dueDate - $duration;
            Project::create(array(
                'prefix'=>$faker->randomElement(['PR','TS','WB']),
                'name'=>$faker->sentence(2),
                //lets say 90% of projects have summary
                'summary'=>$faker->sentence(6),
                //lets say only 80% of project have description
                'description'=>$faker->paragraph(6),
                'avatar'=>'assets/avatars/projects/'.strval(rand(1,80)).'.png',
                'owner_id'=>$faker->randomElement($product_owners)->id,
                'kind_id'=>rand(1,$kind_num),
                //lets say around 85% has due date
                'end_date'=> rand(0,100)<85?date("Y-m-d H:i:s",$dueDate):null,
                //let say 90% of projects are public
                'is_public'=> rand(0,100)<90,
                //let say 90% of projects are active
                'is_active'=> rand(0,100)<90,
                //let say 95% of projects are opt_request enabled
                'opt_request'=> rand(0,100)<95,
                //let say 95% of projects are opt_requirement enabled
                'opt_requirement'=> rand(0,100)<95,
                //let say 95% of projects are opt_testexecution enabled
                'opt_testexecution'=> rand(0,100)<95,
                //let say 95% of projects are opt_bugs enabled
                'opt_bugs'=> rand(0,100)<95,
                'api_key'=>Hash::make($faker->sentence(20)),
                'created_at'=>date("Y-m-d H:i:s",$createdDate)
            ));
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Model\ProjectManagement\Project;
use App\Model\ProjectManagement\ProjectAssignment;
use Faker\Factory as Faker;
class ProjectAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $scrum_masters = DB::table('users')->select('id')->where('role_id','=','2')->get();
        $prod_owners = DB::table('users')->select('id')->where('role_id','=','3')->get();
        $dev_leaders = DB::table('users')->select('id')->where('role_id','=','4')->get();
        $test_leaders = DB::table('users')->select('id')->where('role_id','=','7')->get();
        $sw_architects = DB::table('users')->select('id')->where('role_id','=','5')->get();
        $test_architects = DB::table('users')->select('id')->where('role_id','=','8')->get();
        $developers = DB::table('users')->select('id')->where('role_id','=','6')->get();
        $testers = DB::table('users')->select('id')->where('role_id','=','9')->get();
        $proj_num = Project::count();
        $seed_limit = require_once('Config.php');
        for($i=1;$i<=$proj_num;++$i)
        {
            if($i%50==0)
                $this->command->info('Project seeds: '.$i.' projects out of '.$proj_num.' projects');
            //lets say 1 project team consist of 1 SM, 1 PO, 1 DL, 1 TL, 1 SW, 1 TA, 2-4 devs, 2-4 testers
            ProjectAssignment::create(array(
                'user_id'=>$faker->randomElement($scrum_masters)->id,
                'project_id'=>$i,
                'role_id'=>2
            ));
            ProjectAssignment::create(array(
                'user_id'=>$faker->randomElement($prod_owners)->id,
                'project_id'=>$i,
                'role_id'=>3
            ));
            ProjectAssignment::create(array(
                'user_id'=>$faker->randomElement($dev_leaders)->id,
                'project_id'=>$i,
                'role_id'=>4
            ));
            ProjectAssignment::create(array(
                'user_id'=>$faker->randomElement($test_leaders)->id,
                'project_id'=>$i,
                'role_id'=>7
            ));
            ProjectAssignment::create(array(
                'user_id'=>$faker->randomElement($sw_architects)->id,
                'project_id'=>$i,
                'role_id'=>5
            ));
            ProjectAssignment::create(array(
                'user_id'=>$faker->randomElement($test_architects)->id,
                'project_id'=>$i,
                'role_id'=>8
            ));
            $dev_num = rand(2,4);
            for($j=0;$j<$seed_limit['projects']['max_developers'];$j++)
                ProjectAssignment::create(array(
                    'user_id'=>$faker->randomElement($developers)->id,
                    'project_id'=>$i,
                    'role_id'=>6
                ));
            $test_num = rand(2,$seed_limit['projects']['max_tester']);
            for($j=0;$j<$test_num;$j++)
                ProjectAssignment::create(array(
                    'user_id'=>$faker->randomElement($testers)->id,
                    'project_id'=>$i,
                    'role_id'=>9
                ));
        }
    }
}

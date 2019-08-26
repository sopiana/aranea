<?php

use App\Model\ProjectManagement\Project;
use App\Model\TestCaseManagement\TestSuite;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TestSuiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectNum = Project::count();
        $faker = Faker::create();
        $project_limit=require('Config.php');
        for($i=1;$i<=$projectNum;$i++)
        {
            if($i%200 ==0)
                $this->command->info('Test Suite Seed :'.$i.' out of: '.$projectNum);
            $TestsTestArch = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=',$i]])->
                whereIn('role_id',[7,8,9])->get();
            //let's say Tester, Test Lead and Test Architect together create around 20-40 folder per projects
            $numberOfTestSuites = rand($project_limit['projects']['min_test_suite'],$project_limit['projects']['max_test_suite']);
            for($j=0;$j<$numberOfTestSuites;++$j)
            {
                TestSuite::create(array(
                    'project_id'=>$i,
                    'name'=>$faker->sentence(4),
                    //let's say only 90% of Test Suite have description
                    'description'=>rand(0,100)<80?$faker->paragraph(6):null,
                    'creator_id'=>$faker->randomElement($TestsTestArch)->user_id
                ));
            }
        }
    }
}

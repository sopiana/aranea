<?php

use Illuminate\Database\Seeder;
use App\Model\ProjectManagement\Project;
use App\Model\TestCaseManagement\TestCase;
use App\Model\TestCaseManagement\TestStep;
use App\Model\TestCaseManagement\TestStepLink;
use Faker\Factory as Faker;

class TestCaseSeeder extends Seeder
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
        $testCaseID=1;
        $testStepID=1;
        $project_limit = require('Config.php');
        for($i=1;$i<=$projectNum;$i++)
        {
            $this->command->info('Test Case Seed for project:'.$i.' out of: '.$projectNum.' projects');
            //let's say that the request is submitted by DevLead, Developers and System Architect
            $TestLeadArch = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->
                whereIn('role_id',[7,8])->get();
            $tests = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->
                whereIn('role_id',[7,8,9])->get();
            $members = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->get();
            $testSuites = DB::table('test_suites')->select('id')->
                where([['project_id','=', $i]])->get();
            //lets say 1 project has 300-1200 test cases
            $date_creation =DB::table('projects')->select('created_at')->where('id','=',$i)->get()[0]->created_at;

            $testCasesNum = rand($project_limit['projects']['min_test_case'],$project_limit['projects']['max_test_case']);
            for($j=0;$j<$testCasesNum;++$j)
            {
                if($j%50==0)
                    $this->command->info('  Creating :'.$j.' test case out of: '.$testCasesNum);
                $tc_status = rand(0,100);
                $assignee = null;
                if($tc_status<10)
                {
                    $tc_status = 23; //submitted
                    $assignee = $faker->randomElement($TestLeadArch);
                }
                else if($tc_status<20)
                {
                    $tc_status = 24; //reviewed
                    $assignee = $faker->randomElement($tests);
                }
                else if($tc_status<22)
                {
                    $tc_status = 25; //rejected
                    $assignee = $faker->randomElement($TestLeadArch);
                }
                else if($tc_status<37)
                {
                    $tc_status = 26; //script created
                    $assignee = $faker->randomElement($TestLeadArch);
                }
                else if($tc_status<52)
                {
                    $tc_status = 27; //script reviewed
                    $assignee = $faker->randomElement($tests);
                }
                else if($tc_status<92)
                    $tc_status = 28; //completed
                else if($tc_status<98)
                    $tc_status = rand(29,30); //postponed
                else
                    $tc_status =31;

                //lets say 75% request has VISIBILITY_NONE, 20% has VISIBILITY_PROJECT and 5% has VISIBILITY_PRIVATE
                $visibility = rand(0,100);
                $visibilityStr ='';
                if($visibility<75)
                    $visibilityStr = 'VISIBILITY_NONE';
                else if($visibility<95)
                    $visibilityStr = 'VISIBILITY_PROJECT';
                else
                    $visibilityStr = 'VISIBILITY_PRIVATE';
                $priority = rand(0,100);
                $priorityStr = '';
                if($priority<60)
                    $priorityStr = 'PRIORITY_LOW';
                else if($priority<80)
                    $priorityStr = 'PRIORITY_MEDIUM';
                else if($priority<95)
                    $priorityStr = 'PRIORITY_HIGH';
                else
                    $priorityStr = 'PRIORITY_URGENT';
                $tcSubmitterId = $faker->randomElement($tests)->user_id;
                $last_dateView = strtotime($date_creation)+rand(7776000,15552000);
                TestCase::create(array(
                    'project_id'=>$i,
                    'submitter_id'=>$tcSubmitterId,
                    //let's say around 95% request are in folder and rest is on root
                    'test_suite_id'=>rand(0,60)<95?$faker->randomElement($testSuites)->id:null,
                    'version'=>"".rand(1,3).'.'.rand(0,10).'.'.rand(0,10),
                    'status'=>$tc_status,
                    'summary'=>$faker->sentence(20),
                    //lets say only 90% request has detailed description
                    'description'=>rand(0,100)<90?$faker->paragraph(6):null,
                    //lets say only 95% request has detailed objective
                    'objective'=>rand(0,100)<95?$faker->sentence(10):null,
                     //lets say only 60% request has detailed preconditions
                     'preconditions'=>rand(0,100)<60?$faker->sentence(6):null,
                    //lets say 75% request has VISIBILITY_NONE, 20% has VISIBILITY_PROJECT and 5% has VISIBILITY_PRIVATE
                    'visibility'=>$visibilityStr,
                    //lets say 95% of requests are active and only 5% is archived
                    'is_active'=>rand(0,100)<95?true:false,
                    'assignee'=>$assignee==null?null:$assignee->user_id,
                    'priority'=> $priorityStr,
                    //lets say 70% of test case have due date
                    'due_date'=>rand(0,100)<70?date("Y-m-d",$last_dateView):null,
                    'last_author'=>$faker->randomElement($members)->user_id,
                    // 'attachment'=> rand(0,100)<40?$faker->sentence(4):null
                ));
                //lets say each test case have 4-15 steps
                $numSteps = rand(4,15);
                for($k=0;$k<$numSteps;++$k)
                {
                    TestStep::create(array(
                        'actions'=>$faker->sentence(15),
                        'expected_result'=>$faker->sentence(15),
                        'last_author'=>$tcSubmitterId,
                    ));
                    TestStepLink::create(array(
                        'test_case_id'=>$testCaseID,
                        'test_step_id'=>$testStepID,
                        'test_step_number'=>($k+1),
                        'last_author'=>$tcSubmitterId
                    ));
                    $testStepID++;
                }
                $testCaseID++;
            }
        }
    }
}

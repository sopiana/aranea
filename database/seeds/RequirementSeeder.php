<?php
use App\Model\ProjectManagement\Project;
use App\Model\RequirementManagement\Requirement;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class RequirementSeeder extends Seeder
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
        $project_limit = require('Config.php');
        for($i=1;$i<=$projectNum;$i++)
        {
            if($i%20 ==0)
                $this->command->info('Requirement Seed :'.$i.' out of: '.$projectNum);
            //let's say that the request is submitted by DevLead, Developers and System Architect
            $DevsSysArch = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->
                whereIn('role_id',[4,5,6])->get();
            $devs = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->
                whereIn('role_id',[3,4])->get();
            $tests = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->
                whereIn('role_id',[7,8,9])->get();
            $members = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->get();
            $folders = DB::table('folder_requirements')->select('id')->
                where([['project_id','=', $i]])->get();

            //lets say that we have around 200-400 requests per projects
            $requirementsNum = rand($project_limit['projects']['min_requirement'],$project_limit['projects']['max_requirement']);
            for($j=0;$j<$requirementsNum;++$j)
            {
                $req_status = rand(0,100);
                $assignee = null;
                if($req_status<10)
                {
                    $req_status = 12; //submitted
                    $assignee = $faker->randomElement($devs);
                }
                else if($req_status<20)
                {
                    $req_status = 13; //reviewed
                    $assignee = $faker->randomElement($devs);
                }
                else if($req_status<22)
                {
                    $req_status = 15; //rejected
                    $assignee = $faker->randomElement($DevsSysArch);
                }
                else if($req_status<37)
                {
                    $req_status = 14; //accepted
                    $assignee = $faker->randomElement($devs);
                }
                else if($req_status<52)
                {
                    $req_status = 16; //implemented
                    $assignee = $faker->randomElement($tests);
                }
                else if($req_status<72)
                {
                    $req_status = 17; //tested
                    $assignee = $faker->randomElement($tests);
                }
                else if($req_status<92)
                    $req_status = 18; //completed
                else if($req_status<98)
                    $req_status = rand(19,21); //postponed
                else
                    $req_status =22;

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
                Requirement::create(array(
                    'project_id'=>$i,
                    'submitter_id'=>$faker->randomElement($DevsSysArch)->user_id,
                    //let's say around 60% request are in folder and rest is on root
                    'folder_id'=>rand(0,60)<60?$faker->randomElement($folders)->id:null,
                    'status'=>$req_status,
                    'summary'=>$faker->sentence(20),
                    //lets say only 90% request has detailed description
                    'description'=>rand(0,100)<90?$faker->paragraph(6):null,
                    //lets say 75% request has VISIBILITY_NONE, 20% has VISIBILITY_PROJECT and 5% has VISIBILITY_PRIVATE
                    'visibility'=>$visibilityStr,
                    //lets say 95% of requests are active and only 5% is archived
                    'is_active'=>rand(0,100)<95?true:false,
                    'assignee'=>$assignee==null?null:$assignee->user_id,
                    'priority'=> $priorityStr,

                    'last_author'=>$faker->randomElement($members)->user_id
                    // 'attachment'=> rand(0,100)<40?$faker->sentence(4):null
                ));
            }
        }
    }
}

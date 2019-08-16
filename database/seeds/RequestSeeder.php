<?php
use App\Model\ProjectManagement\Project;
use App\Model\RequestManagement\Request;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RequestSeeder extends Seeder
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
        for($i=1;$i<=$projectNum;$i++)
        {
            if($i%100 ==0)
                $this->command->info('Request Seed :'.$i.' out of: '.$projectNum);
            //let's say that the request is submitted by AoSM and System Architect
            $AoSM = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->
                whereIn('role_id',[2,3,5])->get();
            $devs = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->
                whereIn('role_id',[3,4])->get();
            $tests = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->
                whereIn('role_id',[7,8,9])->get();
            $members = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->get();
            $folders = DB::table('folder_requests')->select('id')->
                where([['project_id','=', $i]])->get();

            //lets say that we have around 70-100 requests per projects
            $requestNum = rand(70,100);
            for($j=0;$j<$requestNum;++$j)
            {
                $req_status = rand(0,100);
                $assignee = null;
                if($req_status<10)
                {
                    $req_status = 1; //submitted
                    $assignee = $faker->randomElement($devs);
                }
                else if($req_status<20)
                {
                    $req_status = 2; //reviewed
                    $assignee = $faker->randomElement($devs);
                }
                else if($req_status<22)
                {
                    $req_status = 3; //rejected
                    $assignee = $faker->randomElement($AoSM);
                }
                else if($req_status<37)
                {
                    $req_status = 4; //accepted
                    $assignee = $faker->randomElement($devs);
                }
                else if($req_status<52)
                {
                    $req_status = 5; //implemented
                    $assignee = $faker->randomElement($tests);
                }
                else if($req_status<72)
                {
                    $req_status = 6; //tested
                    $assignee = $faker->randomElement($tests);
                }
                else if($req_status<92)
                    $req_status = 7; //completed
                else if($req_status<98)
                    $req_status = rand(9,10); //postponed
                else
                    $req_status =11;

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
                Request::create(array(
                    'project_id'=>$i,
                    'submitter_id'=>$faker->randomElement($AoSM)->user_id,
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

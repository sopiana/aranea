<?php
use App\Model\ProjectManagement\Project;
use App\Model\ReleaseManagement\Release;
use App\Model\ReleaseManagement\ReleaseBuild;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ReleaseSeeder extends Seeder
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
        $release_id = 1;
        $project_limit = require('Config.php');
        for($i=1;$i<=$projectNum;$i++)
        {
            if($i%50==0)
                $this->command->info('Release Seed for project:'.$i.' out of: '.$projectNum.' projects');
            //let's say that the Release is submitted by DevLead or Requested by PO
            $devLeadArch = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->
                whereIn('role_id',[4, 3])->get();
            $tests = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->
                whereIn('role_id',[7,8,9])->get();
            $devs = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=', $i]])->
                whereIn('role_id',[4,6])->get();

            $date_creation =DB::table('projects')->select('created_at')->where('id','=',$i)->get()[0]->created_at;

            //lets say 1 project has 15-60 releases
            $releaseNum = rand($project_limit['projects']['min_release'],$project_limit['projects']['max_release']);
            for($j=0;$j<$releaseNum;++$j)
            {
                if($j%10==0)
                    $this->command->info('  Release Seed for project:'.$i.', '.$j.' out of: '.$releaseNum.' releases');
                $rel_status = rand(0,100);
                $assignee = null;
                if($rel_status<20)
                {
                    $rel_status = 37; //created
                    $assignee = $faker->randomElement($devs);
                }
                else if($rel_status<55)
                {
                    $rel_status = 38; //tested
                    $assignee = $faker->randomElement($tests);
                }
                else if($rel_status<95)
                {
                    $rel_status = 39; //completed
                    $assignee = $faker->randomElement($devLeadArch);
                }
                else
                {
                    $rel_status = 40; //postponed
                    $assignee = $faker->randomElement($devLeadArch);
                }

                $started_at = strtotime($date_creation)+rand(76000,152000);
                $ended_at = strtotime($date_creation)+rand(76000,152000);
                Release::create(array(
                    'name'=>$faker->sentence(5),
                    'type'=>$faker->randomElement(['REL_TYPE_MAJOR','REL_TYPE_MINOR','REL_TYPE_SPRINT']),
                    'project_id'=>$i,
                    'status'=>$rel_status,
                    'submitter_id'=>$faker->randomElement($devLeadArch)->user_id,
                    'owner_id'=>$assignee->user_id,
                    'version'=>"".rand(1,3).'.'.rand(0,10).'.'.rand(0,10),
                    'started_at'=>date("Y-m-d", $started_at),
                    'ended_at'=>date("Y-m-d", $ended_at),
                    //lets say 70% has info
                    'info'=>rand(0,100)<70?$faker->paragraph(3):null,
                    //lets say 40% has info
                    'note'=>rand(0,100)<70?$faker->paragraph(5):null
                ));
                //lets say each test case have 5-20 steps
                $numBuilds = rand(5,20);
                for($k=0;$k<$numBuilds;++$k)
                {
                    ReleaseBuild::create(array(
                        'release_id'=>$release_id,
                        'build_number'=>''.($k+1),
                        'description'=>rand(0,100)<40?$faker->paragraph(2):null,
                        'build_log'=>$faker->paragraph(4),
                        'status'=>$faker->randomElement(['BUILD_ABORTED','BUILD_FAILED','BUILD_SUCCESS','BUILD_UNSTABLE']),
                        'author'=> $assignee->user_id
                    ));
                }
                $release_id++;
            }
        }
    }
}

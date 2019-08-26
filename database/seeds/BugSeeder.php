<?php

use App\Model\BugManagement\Bug;
use App\Model\ProjectManagement\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BugSeeder extends Seeder
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
        $status = DB::table('status')->select('id')->where([['type','=','TYPE_BUGS']])->get();
        $project_limit = require('Config.php');
        for($i=1;$i<=$projectNum;$i++)
        {
            $members = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=',$i]])->get();
            $releases = DB::table('releases')->select('id')->
                where([['project_id','=',$i]])->get();
            //let's say each project has 100-2000 issue
            $numberOfBugs = rand($project_limit['projects']['min_bug'],$project_limit['projects']['max_bug']);
            for($j=0;$j<$numberOfBugs;++$j)
            {
                if($j%50 ==0)
                    $this->command->info('Bugs Seed :'.$j.' out of: '.$numberOfBugs .' for projects id: '.$i);
                //Now the data is fully random
                Bug::create(array(
                    'project_id'=>$i,
                    'type'=>$faker->randomElement(array('TYPE_BUG', 'TYPE_ISSUE', 'TYPE_LIMITATION')),
                    'summary'=>$faker->sentence(20),
                    'status'=>$faker->randomElement($status)->id,
                    'detected_release_id'=>$faker->randomElement($releases)->id,
                    'resolved_release_id'=>rand(0,100)<80?$faker->randomElement($releases)->id:null,
                    'verified_release_id'=>rand(0,100)<65?$faker->randomElement($releases)->id:null,
                    'submitter_id'=>$faker->randomElement($members)->user_id,
                    'visibility'=>$faker->randomElement(array('VISIBILITY_NONE','VISIBILITY_PRIVATE','VISIBILITY_PROJECT')),
                    'assignee'=>$faker->randomElement($members)->user_id,
                    'priority'=>$faker->randomElement(array('PRIORITY_LOW','PRIORITY_MEDIUM','PRIORITY_HIGH','PRIORITY_URGENT')),
                    'severity'=>$faker->randomElement(array('SEVERITY_LOW','SEVERITY_MEDIUM','SEVERITY_HIGH','SEVERITY_CRITICAL')),
                    'description'=>$faker->paragraph(5),
                    'note'=>rand(0,100)<45?$faker->paragraph(3):null,
                ));
            }
        }
    }
}

<?php
use App\Model\ProjectManagement\Project;
use App\Model\TaskManagement\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
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
        $status = DB::table('status')->select('id')->where([['type','=','TYPE_TASK']])->get();
        for($i=1;$i<=$projectNum;$i++)
        {
            $members = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=',$i]])->get();
            foreach($members as $member)
            {
                //let's say each members has 75-150 tasks
                $numberOfTasks = rand(75,250);
                for($j=0;$j<$numberOfTasks;++$j)
                {
                    if($j%20==0)
                        $this->command->info('Tasks Seed :'.$j.' out of: '.$numberOfTasks .' for user id: '.$member->user_id.' on projects id: '.$i);
                    //Now the data is fully random
                    Task::create(array(
                        'project_id'=>$i,
                        'status'=>$faker->randomElement($status)->id,
                        'submitter_id'=>$faker->randomElement($members)->user_id,
                        'visibility'=>$faker->randomElement(['VISIBILITY_NONE','VISIBILITY_PRIVATE','VISIBILITY_PROJECT']),
                        'is_active'=>rand(0,100)<90,
                        'assignee'=>$member->user_id,
                        'priority'=>$faker->randomElement(['PRIORITY_LOW','PRIORITY_MEDIUM','PRIORITY_HIGH','PRIORITY_URGENT']),
                        'summary'=>$faker->sentence(15),
                        'description'=>rand(0,100)<70?$faker->paragraph(5):null
                    ));
                }
            }
        }
    }
}

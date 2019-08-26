<?php

use Illuminate\Database\Seeder;
use App\Model\ProjectManagement\Project;
use App\Model\RequestManagement\FolderRequest;
use Faker\Factory as Faker;

class FolderRequestSeeder extends Seeder
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
                $this->command->info('Folder Request Seed :'.$i.' out of: '.$projectNum);
            $AoSM = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=',$i]])->
                whereIn('role_id',[2,3])->get();
            //let's say AO and Scrum Master together create around 20-30 folder per projects
            $numberOfFolders = rand($project_limit['projects']['min_folder_request'],$project_limit['projects']['max_folder_request']);
            for($j=0;$j<$numberOfFolders;++$j)
            {
                FolderRequest::create(array(
                    'project_id'=>$i,
                    'name'=>$faker->sentence(4),
                    //let's say only 80% of folder have description
                    'description'=>rand(0,100)<80?$faker->paragraph(6):null,
                    'creator_id'=>$faker->randomElement($AoSM)->user_id
                ));
            }
        }
    }
}

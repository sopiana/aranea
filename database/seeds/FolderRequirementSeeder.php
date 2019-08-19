<?php

use App\Model\RequirementManagement\FolderRequirement;
use App\Model\ProjectManagement\Project;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class FolderRequirementSeeder extends Seeder
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
            if($i%200 ==0)
                $this->command->info('Folder Requirement Seed :'.$i.' out of: '.$projectNum);
            $DevLeadSysArch = DB::table('project_assignments')->select('user_id','role_id')->
                where([['project_id','=',$i]])->
                whereIn('role_id',[4,5])->get();
            //let's say Dev Lead and System Architect together create around 40-60 folder per projects
            $numberOfFolders = rand(40,60);
            for($j=0;$j<$numberOfFolders;++$j)
            {
                FolderRequirement::create(array(
                    'project_id'=>$i,
                    'name'=>$faker->sentence(4),
                    //let's say only 80% of folder have description
                    'description'=>rand(0,100)<80?$faker->paragraph(6):null,
                    'creator_id'=>$faker->randomElement($DevLeadSysArch)->user_id
                ));
            }
        }
    }
}

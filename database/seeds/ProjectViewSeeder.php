<?php

use Illuminate\Database\Seeder;
use App\Model\ProjectManagement\ProjectView;
use App\Model\ProjectManagement\Project;
use App\Model\UserManagement\User;

class ProjectViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assigned_projects = DB::table('project_assignments')->select('project_id','user_id')->get();
        //lets say that each users view around 200-500 times on project they owned
        $total = $assigned_projects->count();
        $idx = 0;
        foreach($assigned_projects as $assign_project)
        {
            if($idx%200==0)
                $this->command->info('Project View seeds: '.$idx.' items out of '.$total);
            $idx++;
            $date_creation =DB::table('projects')->select('created_at')->where('id','=',$assign_project->project_id)->get()[0]->created_at;
            // $this->command->info(json_encode($assign_project));
            $last_dateView = strtotime($date_creation)+rand(7776000,15552000);

            ProjectView::create(array(
                'project_id'=>$assign_project->project_id,
                'user_id'=>$assign_project->user_id,
                'view_count'=>rand(200,500),
                'last_visited'=>date("Y-m-d H:i:s",$last_dateView)
            ));
        }
        //lets say that each users view around 30-100 times on 20-50 projects they are not owned
        $user_num = User::count();
        $project_num = Project::count();
        for($id=1;$id<=$user_num;++$id)
        {
            if($id%200==0)
                $this->command->info('Random Project View seeds: '.$id.' items out of '.$user_num);
            $projects_viewed_num = rand(20,50);
            for($j=0;$j<$projects_viewed_num;++$j)
            {
                $rand_project = rand(1,$project_num);
                $date_creation =DB::table('projects')->select('created_at')->where('id','=',$rand_project)->get()[0]->created_at;
                if(DB::table('project_views')->select('project_id')->where('project_id','=',$rand_project)->get()->count()>0)
                    continue;
                //$this->command->info(json_encode($assign_project));
                $last_dateView = strtotime($date_creation)+rand(7776000,15552000);
                $this->command->info($last_dateView);
                ProjectView::create(array(
                    'project_id'=>$rand_project,
                    'user_id'=>$id,
                    'view_count'=>rand(30,100),
                    'last_visited'=>date("Y-m-d H:i:s",$last_dateView)
                ));
            }
        }
    }
}

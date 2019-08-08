<?php

namespace App\Model\ProjectManagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

define('VIEW_PROJECT','view_projects');
define('VIEW_PROJECT_ASSIGNMENT','view_project_assignments');

class Project extends Model
{
    protected $table = 'projects';
    public $timestamps = false;

    public static function getLastViewedProject($userId){
        return DB::table(VIEW_PROJECT)->
            join('project_views',VIEW_PROJECT.'.id','=','project_views.project_id')->
            where('project_views.user_id', $userId)->
            orderByDesc('project_views.last_visited')->first();
    }

    public static function getRecentProjects($userId, $start, $limit){
        return DB::table(VIEW_PROJECT_ASSIGNMENT)->
            join(VIEW_PROJECT,VIEW_PROJECT_ASSIGNMENT.'.project_id','=',VIEW_PROJECT.'.id')->
            select(VIEW_PROJECT.'.*')->
            where(VIEW_PROJECT_ASSIGNMENT.'.user_id', $userId)->
            skip($start)->limit($limit)->
            orderByDesc(VIEW_PROJECT.'.created_at')->
            get();
    }
}

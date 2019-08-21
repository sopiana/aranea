<?php

namespace App\Model\TaskManagement;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

define('VIEW_TASK','view_task');

class Task extends Model
{
    protected $table = 'tasks';
    public $timestamps = false;

    public static function getTaskList($userId, $start=-1, $limit=-1){
        $query= DB::table(VIEW_TASK)->
                select(VIEW_TASK.'.id',VIEW_TASK.'.project_id',VIEW_TASK.'.project_prefix', VIEW_TASK.'.summary',
                    VIEW_TASK.'.submitter_id', VIEW_TASK.'.submitter_name', VIEW_TASK.'.submitter_avatar',
                    VIEW_TASK.'.status_id', VIEW_TASK.'.status_name',
                    VIEW_TASK.'.visibility', VIEW_TASK.'.is_active', VIEW_TASK.'.assignee_id',
                    VIEW_TASK.'.assignee_name', VIEW_TASK.'.assignee_avatar', VIEW_TASK.'.priority',
                    VIEW_TASK.'.created_at')->
                where(VIEW_TASK.'.submitter_id', $userId)->
                orWhere(VIEW_TASK.'.assignee_id', $userId)->
                orderByDesc(VIEW_TASK.'.created_at');
        if($start>=0)
            $query->skip($start)->limit($limit);
        return $query->get();
    }
}

<?php

namespace App\Model\RequirementManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

define('VIEW_REQUIREMENT','view_requirement');
class Requirement extends Model
{
    protected $table = 'requirements';
    public $timestamps = false;
    public static function getRequirementList($userId, $start=-1, $limit=-1){
        $query= DB::table(VIEW_REQUIREMENT)->
                select(VIEW_REQUIREMENT.'.id',VIEW_REQUIREMENT.'.project_id',VIEW_REQUIREMENT.'.project_prefix', VIEW_REQUIREMENT.'.summary',
                    VIEW_REQUIREMENT.'.submitter_id', VIEW_REQUIREMENT.'.submitter_name', VIEW_REQUIREMENT.'.submitter_avatar',
                    VIEW_REQUIREMENT.'.folder_id', VIEW_REQUIREMENT.'.status_id', VIEW_REQUIREMENT.'.status_name',
                    VIEW_REQUIREMENT.'.visibility', VIEW_REQUIREMENT.'.is_active', VIEW_REQUIREMENT.'.assignee_id',
                    VIEW_REQUIREMENT.'.assignee_name', VIEW_REQUIREMENT.'.assignee_avatar', VIEW_REQUIREMENT.'.priority',
                    VIEW_REQUIREMENT.'.created_at')->
                where(VIEW_REQUIREMENT.'.submitter_id', $userId)->
                orWhere(VIEW_REQUIREMENT.'.assignee_id', $userId)->
                orderByDesc(VIEW_REQUIREMENT.'.created_at');
        if($start>=0)
            $query->skip($start)->limit($limit);
        return $query->get();
    }
}

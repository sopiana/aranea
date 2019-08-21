<?php

namespace App\Model\RequestManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

define('VIEW_REQUEST','view_request');
class Request extends Model
{
    protected $table = 'requests';
    public $timestamps = false;
    public static function getRequestList($userId, $start=-1, $limit=-1){
        $query= DB::table(VIEW_REQUEST)->
                select(VIEW_REQUEST.'.id',VIEW_REQUEST.'.project_id',VIEW_REQUEST.'.project_prefix', VIEW_REQUEST.'.summary',
                    VIEW_REQUEST.'.submitter_id', VIEW_REQUEST.'.submitter_name', VIEW_REQUEST.'.submitter_avatar',
                    VIEW_REQUEST.'.folder_id', VIEW_REQUEST.'.status_id', VIEW_REQUEST.'.status_name',
                    VIEW_REQUEST.'.visibility', VIEW_REQUEST.'.is_active', VIEW_REQUEST.'.assignee_id',
                    VIEW_REQUEST.'.assignee_name', VIEW_REQUEST.'.assignee_avatar', VIEW_REQUEST.'.priority',
                    VIEW_REQUEST.'.created_at')->
                where(VIEW_REQUEST.'.submitter_id', $userId)->
                orWhere(VIEW_REQUEST.'.assignee_id', $userId)->
                orderByDesc(VIEW_REQUEST.'.created_at');
        if($start>=0)
            $query->skip($start)->limit($limit);
        return $query;
    }
}

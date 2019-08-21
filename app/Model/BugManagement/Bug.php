<?php

namespace App\Model\BugManagement;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
define('VIEW_BUG','view_bug');

class Bug extends Model
{
    protected $table = 'bugs';
    public $timestamps = false;
    public static function getBugList($userId, $start=-1, $limit=-1)
    {
        $query= DB::table(VIEW_BUG)->
                select(VIEW_BUG.'.id',VIEW_BUG.'.project_id',VIEW_BUG.'.project_prefix',
                    VIEW_BUG.'.summary', VIEW_BUG.'.type',
                    VIEW_BUG.'.submitter_id', VIEW_BUG.'.submitter_name', VIEW_BUG.'.submitter_avatar',
                    VIEW_BUG.'.status_id', VIEW_BUG.'.status_name',
                    VIEW_BUG.'.visibility',
                    VIEW_BUG.'.assignee_id', VIEW_BUG.'.assignee_name', VIEW_BUG.'.assignee_avatar',
                    VIEW_BUG.'.priority',VIEW_BUG.'.severity',
                    VIEW_BUG.'.created_at')->
                where(VIEW_BUG.'.submitter_id', $userId)->
                orWhere(VIEW_BUG.'.assignee_id', $userId)->
                orderByDesc(VIEW_BUG.'.created_at');
        if($start>=0)
            $query->skip($start)->limit($limit);
        return $query;
    }
}

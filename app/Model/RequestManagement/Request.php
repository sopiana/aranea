<?php

namespace App\Model\RequestManagement;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';
    public $timestamps = false;
    public static function getRequestList($userId, $start=-1, $limit=-1){
        // $query= DB::table(VIEW_PROJECT_ASSIGNMENT)->
        //         join(VIEW_PROJECT,VIEW_PROJECT_ASSIGNMENT.'.project_id','=',VIEW_PROJECT.'.id')->
        //         select(VIEW_PROJECT.'.*')->
        //         where(VIEW_PROJECT_ASSIGNMENT.'.user_id', $userId)->
        //         orderByDesc(VIEW_PROJECT.'.created_at');
        // if($start>=0)
        //     $query->skip($start)->limit($limit);
        // return $query->get();
    }
}

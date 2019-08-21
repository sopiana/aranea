<?php

namespace App\Model\ReleaseManagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

define('VIEW_RELEASE','view_release');

class Release extends Model
{
    protected $table = 'releases';
    public $timestamps = false;
    public static function getReleaseList ($userId, $start=-1, $limit=-1)
    {
        $query= DB::table(VIEW_RELEASE)->
                select(VIEW_RELEASE.'.id',VIEW_RELEASE.'.project_id',VIEW_RELEASE.'.project_prefix',
                    VIEW_RELEASE.'.name', VIEW_RELEASE.'.type',
                    VIEW_RELEASE.'.submitter_id', VIEW_RELEASE.'.submitter_name', VIEW_RELEASE.'.submitter_avatar',
                    VIEW_RELEASE.'.status_id', VIEW_RELEASE.'.status_name',
                    VIEW_RELEASE.'.owner_id', VIEW_RELEASE.'.owner_name', VIEW_RELEASE.'.owner_avatar',
                    VIEW_RELEASE.'.version', VIEW_RELEASE.'.started_at',
                    VIEW_RELEASE.'.ended_at', VIEW_RELEASE.'.created_at')->
                where(VIEW_RELEASE.'.submitter_id', $userId)->
                orWhere(VIEW_RELEASE.'.owner_id', $userId)->
                orderByDesc(VIEW_RELEASE.'.created_at');
        if($start>=0)
            $query->skip($start)->limit($limit);
        return $query;
    }
}

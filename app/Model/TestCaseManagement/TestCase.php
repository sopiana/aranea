<?php

namespace App\Model\TestCaseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

define('VIEW_TEST_CASE','view_test_case');
class TestCase extends Model
{
    protected $table = 'test_cases';
    public $timestamps = false;

    public static function getTestCaseList ($userId, $start=-1, $limit=-1){
        $query= DB::table(VIEW_TEST_CASE)->
                select(VIEW_TEST_CASE.'.id',VIEW_TEST_CASE.'.project_id',VIEW_TEST_CASE.'.project_prefix', VIEW_TEST_CASE.'.summary',
                    VIEW_TEST_CASE.'.submitter_id', VIEW_TEST_CASE.'.submitter_name', VIEW_TEST_CASE.'.submitter_avatar',
                    VIEW_TEST_CASE.'.test_suite_id', VIEW_TEST_CASE.'.status_id', VIEW_TEST_CASE.'.status_name',
                    VIEW_TEST_CASE.'.visibility', VIEW_TEST_CASE.'.is_active', VIEW_TEST_CASE.'.assignee_id',
                    VIEW_TEST_CASE.'.assignee_name', VIEW_TEST_CASE.'.assignee_avatar', VIEW_TEST_CASE.'.priority',
                    VIEW_TEST_CASE.'.created_at')->
                where(VIEW_TEST_CASE.'.submitter_id', $userId)->
                orWhere(VIEW_TEST_CASE.'.assignee_id', $userId)->
                orderByDesc(VIEW_TEST_CASE.'.created_at');
        if($start>=0)
            $query->skip($start)->limit($limit);
        return $query->get();
    }
}

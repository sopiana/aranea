<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Model\BugManagement\Bug;
use App\Model\ProjectManagement\Project;
use App\Model\ReleaseManagement\Release;
use Illuminate\Support\Facades\Auth;
use App\Model\UserManagement\User;
use App\Model\RequestManagement\Request;
use App\Model\RequirementManagement\Requirement;
use App\Model\TaskManagement\Task;
use App\Model\TestCaseManagement\TestCase;
use Illuminate\Support\Facades\DB;
class SecureApi extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getProfileDetail(){
        return response()->json(User::getProfileData(Auth::user()->id));
    }
    public function getLastViewedProject()
    {
        return response()->json(Project::getLastViewedProject(Auth::user()->id));
    }
    public function getProjectList($start=-1,$limit=50)
    {
        return response()->json(Project::getProjectList(Auth::user()->id, $start, $limit)->get());
    }
    public function getAllItemList($start=-1,$limit=50)
    {
        $requests = Request::getRequestList(Auth::user()->id)->addSelect(DB::raw("'REQUEST' as item_type"));
        $requirements = Requirement::getRequirementList(Auth::user()->id)->addSelect(DB::raw("'REQUIREMENT' as item_type"));
        $testcases = TestCase::getTestCaseList(Auth::user()->id)->addSelect(DB::raw("'TEST_CASE' as item_type"));
        $bugs = Bug::getBugList(Auth::user()->id)->select('id',
            'project_code','summary','submitter_id','submitter_name','submitter_avatar',
            DB::raw('NULL as folder_id'),'status_id','status_name','visibility',
            DB::raw('TRUE as is_active'),'assignee_id','assignee_name',
            'assignee_avatar','priority','created_at', DB::raw("'BUG' as item_type"));
        $releases = Release::getReleaseList(Auth::user()->id)->select('id',
            'project_code','name as summary','submitter_id','submitter_name','submitter_avatar',
            DB::raw('NULL as folder_id'),'status_id','status_name',DB::raw("'VISIBILITY_NONE' as visibility"),
            DB::raw('TRUE as is_active'),'owner_id as assignee_id','owner_name as assignee_name',
            'owner_avatar as assignee_avatar',DB::raw("'PRIORITY_LOW' as priority"),'created_at', DB::raw("'RELEASE' as item_type"));;
        return $requests->
            union($requirements)->
            union($testcases)->
            union($bugs)->
            union($releases)->
            orderByDesc('created_at')->
            get();
    }
    public function getRequestList($start=-1,$limit=50)
    {
        return response()->json(Request::getRequestList(Auth::user()->id, $start, $limit)->get());
    }
    public function getRequirementList($start=-1,$limit=50)
    {
        return response()->json(Requirement::getRequirementList(Auth::user()->id, $start, $limit)->get());
    }
    public function getTestCaseList($start=-1,$limit=50)
    {
        return response()->json(TestCase::getTestCaseList(Auth::user()->id, $start, $limit)->get());
    }
    public function getReleaseList($start=-1,$limit=50)
    {
        return response()->json(Release::getReleaseList(Auth::user()->id, $start, $limit)->get());
    }
    public function getBugList($start=-1,$limit=50)
    {
        return response()->json(Bug::getBugList(Auth::user()->id, $start, $limit)->get());
    }
    public function getTaskList($start=-1,$limit=50)
    {
        return response()->json(Task::getTaskList(Auth::user()->id, $start, $limit)->get());
    }
    public function getProjectDescription($projectCode)
    {
        return response()->json(Project::getProjectDescription($projectCode));
    }
}

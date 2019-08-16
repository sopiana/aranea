<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Model\ProjectManagement\Project;
use Illuminate\Support\Facades\Auth;
use App\Model\UserManagement\User;
use App\Model\RequestManagement\Request;

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
        return response()->json(Project::getProjectList(Auth::user()->id, $start, $limit));
    }
    public function getProjectListCount()
    {
        return response()->json(array('count'=>Project::getProjectListCount(Auth::user()->id)));
    }
    public function getRequestList($start=-1,$limit=50)
    {
        return response()->json(Request::getRequestList(Auth::user()->id, $start, $limit));
    }
}

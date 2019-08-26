<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Model\ProjectManagement\Project;
use App\Model\UserManagement\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
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
    public function default($projectCode)
    {
        $userId = Auth::user()->id;
        return view('project.project')->with('currentProject',Project::getLastViewedProject($userId))->
            with('recentProjects', Project::getProjectList($userId,0,5)->get())->
            with('userData', User::getProfileData($userId))->
            with('selectedProject',Project::getProjectDescription($projectCode));
    }
}

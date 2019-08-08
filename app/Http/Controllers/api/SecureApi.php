<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Model\ProjectManagement\Project;
use Illuminate\Support\Facades\Auth;
use App\Model\UserManagement\User;

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
    public function getRecentProjects($start=0,$limit=50)
    {
        return response()->json(Project::getRecentProjects(Auth::user()->id, $start, $limit));
    }

}

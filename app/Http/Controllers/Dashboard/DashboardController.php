<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\ProjectManagement\Project;
use App\Model\UserManagement\User;

class DashboardController extends Controller
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
    public function default()
    {
        return redirect('/dashboard');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::user()->id;
        return view('dashboard.dashboard')->with('currentProject',Project::getLastViewedProject($userId))->
            with('recentProjects',Project::getProjectList($userId,0,5))->
            with('userData',User::getProfileData($userId));
    }
}

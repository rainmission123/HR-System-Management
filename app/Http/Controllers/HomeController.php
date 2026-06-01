<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\User;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard.home', [
            'totalEmployees' => User::count(),
            'activeEmployees' => User::where('status', 'Active')->count(),
            'departmentsCount' => Department::count(),
            'holidaysCount' => Holiday::count(),
            'pendingLeaves' => Leave::where('status', 'Pending')->count(),
            'approvedLeaves' => Leave::where('status', 'Approved')->count(),
            'declinedLeaves' => Leave::where('status', 'Declined')->count(),
            'recentLeaves' => Leave::latest()->take(8)->get(),
            'recentEmployees' => User::latest()->take(8)->get(),
        ]);
    }
}

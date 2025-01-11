<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAdmin = User::where('role', 'Admin')->count();
        $totalStaff = User::where('role', 'Staff')->count();
        $totalAttendance = Attendance::count();
        $totalPermission = Permission::count();

        return view('pages.dashboard', compact('totalAdmin', 'totalStaff', 'totalAttendance', 'totalPermission'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tasks = Task::get();
        return view('auth.dashboard', compact('tasks'));
    }

    public function getEmployees() 
    {
        $response = Employee::get();
        return response()->json($response);
    }
}

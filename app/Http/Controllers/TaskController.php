<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::get();
        return view('auth.create-task', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $task = Task::create([
                'title' => $request->title,
                'date' => now(),
                'hours_spent' => $request->hours_spent,
                'hourly_rate' => $request->hourly_rate,
                'addtional_charges' => $request->addtional_charges,
                'description' => $request->description,
                'total_remunation' => $request->hours_spent * $request->hourly_rate + $request->addtional_charges
            ]);

    
            foreach($request->employee_task as $item) {
                EmployeeTask::create([
                    'task_id' => $task->id,
                    'employee_id' => $item['employeeId'],
                    'hours' => $item['hours'],
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::debug($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Task::where('id', $id)
            ->with(['employees' => function ($query) {
                $query->select('employees.id', 'employees.name', 'employee_tasks.hours');
            }])
            ->first();
        return view('auth.show-task', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $data = Task::where('id', $id)
            ->with(['employees' => function ($query) {
                $query->select('employees.id', 'employees.name', 'employee_tasks.hours');
            }])
            ->first();
        $employees = Employee::get();

        return view('auth.update-task', compact(['data', 'employees']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'hours_spent' => $request->hours_spent,
            'hourly_rate' => $request->hourly_rate,
            'addtional_charges' => $request->addtional_charges,
            'description' => $request->description,
            'total_remunation' => $request->hours_spent * $request->hourly_rate + $request->addtional_charges
        ]);

        // Simpan relasi employees ke task
        $task->employees()->sync(
            collect($request->employee_task)->mapWithKeys(function ($emp) {
                return [$emp['employeeId'] => ['hours' => $emp['hours']]];
            })
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
    }
}

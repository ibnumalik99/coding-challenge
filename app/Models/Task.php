<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function employeeTask()
    {
        return $this->hasMany(EmployeeTask::class, 'task_id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_tasks', 'task_id', 'employee_id')
            ->withPivot('hours') // Mengambil hours dari pivot table
            ->withTimestamps(); // Menambahkan timestamp jika ada
    }
}

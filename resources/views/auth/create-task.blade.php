@extends('layouts.master')

@section('content')
    <sidebar-component></sidebar-component>
    <div class="p-4 sm:ml-64">
        <div class="text-lg font-bold">Create Task</div>
        <task-form-component :employees="{{ json_encode($employees) }}"></task-form-component>
    </div>
@endsection
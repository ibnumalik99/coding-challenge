@extends('layouts.master')

@section('content')
    <sidebar-component></sidebar-component>
    <div class="p-4 sm:ml-64">
        <div class="text-lg font-bold">Update Task</div>
        <task-form-component :employees="{{ json_encode($employees) }}" :record="{{ json_encode($data) }}"></task-form-component>
    </div>
@endsection
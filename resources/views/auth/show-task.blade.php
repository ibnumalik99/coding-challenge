@extends('layouts.master')

@section('content')
    <sidebar-component></sidebar-component>
    <div class="p-4 sm:ml-64">
        <div class="text-lg font-bold">Show Task</div>
        <show-task-component :record="{{ json_encode($data) }}"></show-task-component>
    </div>
@endsection
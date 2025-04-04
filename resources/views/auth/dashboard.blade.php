@extends('layouts.master')

@section('content')
    <sidebar-component></sidebar-component>
    <div class="p-4 sm:ml-64">
        <task-component :tasks="{{ $tasks }}"></task-component>
     </div>
@endsection
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('tasks.create') }}" class="btn btn-success">Add Task</a>
            <div class="page-header">
                <h2>All Tasks</h2>
            </div>
            @foreach($tasks as $task)
            <div class="card">
                <div class="card-header"><a href="/tasks/{{$task->id}}">{{$task->title}}</a></div>

                <div class="card-body">
                    {{$task->description}}
                </div>
            </div>
            <br>
            @endforeach
        </div>
    </div>
</div>
@endsection
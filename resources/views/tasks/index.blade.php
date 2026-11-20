@extends('layouts.app')

@section('title', 'Задачи')

@section('content')
    <h1>Задачи</h1>
    <p class="text-muted">TaskController::index → view('tasks.index', ['tasks' => Task::all()])</p>

    <ul class="list-group">
        @forelse ($tasks as $task)
            <li class="list-group-item">
                {{ $task->is_done ? '✓' : '○' }} {{ $task->title }}
            </li>
        @empty
            <li class="list-group-item">Няма задачи.</li>
        @endforelse
    </ul>
@endsection

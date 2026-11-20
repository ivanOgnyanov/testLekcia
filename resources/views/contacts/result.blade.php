@extends('layouts.app')

@section('title', 'Изпратени данни')

@section('content')
    <h1>Получени данни</h1>
    <p class="text-muted">ContactController::store → view('contacts.result')->with('input', $input)</p>

    <div class="card card-body">
        <p>Име: {{ $input['name'] }}</p>
        <p>Имейл: {{ $input['email'] }}</p>
        <p>Съобщение: {{ $input['message'] ?? 'Няма съобщение' }}</p>
    </div>

    <a href="{{ route('contacts.create') }}" class="btn btn-link mt-3">← Обратно към формата</a>
@endsection

@extends('layouts.app')

@section('title', 'Резултат от анкетата')

@section('content')
    <h1>Как Request прочете анкетата</h1>

    <table class="table table-bordered bg-white">
        <tr><th>Метод</th><th>Резултат</th></tr>
        <tr><td><code>$request->string('name')->title()</code></td><td>{{ $name }}</td></tr>
        <tr><td><code>$request->input('cities', [])</code></td><td>{{ $cities ? implode(', ', $cities) : '[] (празен масив)' }}</td></tr>
        <tr><td><code>$request->input('cities.0')</code></td><td>{{ $firstCity }}</td></tr>
        <tr><td><code>$request->boolean('newsletter')</code></td><td>{{ $wantsNewsletter ? 'true' : 'false' }}</td></tr>
        <tr><td><code>$request->integer('per_page', 10)</code></td><td>{{ $perPage }} (тип int)</td></tr>
        <tr><td><code>$request->has('comment')</code></td><td>{{ $hasComment ? 'true' : 'false' }}</td></tr>
        <tr><td><code>$request->filled('comment')</code></td><td>{{ $filledComment ? 'true' : 'false' }}</td></tr>
    </table>

    <a href="{{ route('surveys.create') }}" class="btn btn-link">← Обратно към анкетата</a>
@endsection

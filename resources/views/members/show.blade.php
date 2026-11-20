@extends('layouts.app')

@section('title', $member->name)

@section('content')
    <h1>{{ $member->name }}</h1>
    <p class="text-muted">GET /members/{{ $member->id }} → MemberController::show(Member $member) - route model binding</p>

    <div class="card card-body">
        <p>Имейл: {{ $member->email }}</p>
        <p>Регистриран на: {{ $member->created_at->format('d.m.Y H:i') }}</p>
    </div>

    <a href="{{ route('members.index') }}" class="btn btn-link mt-3">← Всички членове</a>
@endsection

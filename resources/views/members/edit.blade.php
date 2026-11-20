@extends('layouts.app')

@section('title', 'Редакция на член')

@section('content')
    <h1>Редакция: {{ $member->name }}</h1>
    <p class="text-muted">PUT /members/{{ $member->id }} → MemberController::update(UpdateMemberRequest $request, Member $member)</p>

    <form method="POST" action="{{ route('members.update', $member) }}" class="card card-body">
        @csrf
        @method('PUT')
        @include('members.partials.form', ['member' => $member])
        <button type="submit" class="btn btn-primary">Обнови</button>
    </form>
@endsection

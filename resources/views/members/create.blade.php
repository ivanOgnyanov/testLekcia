@extends('layouts.app')

@section('title', 'Нов член')

@section('content')
    <h1>Нов член</h1>
    <p class="text-muted">POST /members → MemberController::store(StoreMemberRequest $request, MemberService $members)</p>

    <form method="POST" action="{{ route('members.store') }}" class="card card-body">
        @csrf
        @include('members.partials.form', ['member' => null])
        <button type="submit" class="btn btn-primary">Запиши</button>
    </form>
@endsection

@extends('layouts.app')

@section('title', 'Членове')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Членове</h1>
        <div>
            <a href="{{ route('members.export') }}" class="btn btn-outline-secondary">Експорт (CSV)</a>
            <a href="{{ route('members.create') }}" class="btn btn-primary">+ Нов член</a>
        </div>
    </div>

    <table class="table table-striped bg-white">
        <thead>
            <tr><th>Име</th><th>Имейл</th><th class="text-end">Действия</th></tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
                <tr>
                    <td><a href="{{ route('members.show', $member) }}">{{ $member->name }}</a></td>
                    <td>{{ $member->email }}</td>
                    <td class="text-end">
                        <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-outline-primary">Редакция</a>
                        <form method="POST" action="{{ route('members.destroy', $member) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Изтрий</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">Няма членове.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection

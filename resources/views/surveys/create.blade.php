@extends('layouts.app')

@section('title', 'Анкета')

@section('content')
    <h1>Анкета</h1>

    <form method="POST" action="{{ route('surveys.store') }}" class="card card-body">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Име (напишете с малки букви - вижте string()->title())</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <p class="mb-1">Посетени градове (масив cities[]):</p>
        <div class="mb-3">
            @foreach ($availableCities as $city)
                <div class="form-check form-check-inline">
                    <input type="checkbox" id="city-{{ $loop->index }}" name="cities[]" value="{{ $city }}"
                           class="form-check-input" @checked(in_array($city, old('cities', [])))>
                    <label for="city-{{ $loop->index }}" class="form-check-label">{{ $city }}</label>
                </div>
            @endforeach
        </div>

        <div class="form-check mb-3">
            {{-- без value - отметнатият чекбокс изпраща "on", който boolean() разпознава като true --}}
            <input type="checkbox" id="newsletter" name="newsletter" class="form-check-input" @checked(old('newsletter'))>
            <label for="newsletter" class="form-check-label">Искам бюлетин</label>
        </div>

        <div class="mb-3">
            <label for="per_page" class="form-label">Резултати на страница</label>
            <input type="number" id="per_page" name="per_page" value="{{ old('per_page') }}"
                   class="form-control @error('per_page') is-invalid @enderror">
            @error('per_page')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Коментар (оставете празно и вижте has() и filled())</label>
            <input type="text" id="comment" name="comment" value="{{ old('comment') }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Изпрати</button>
    </form>
@endsection

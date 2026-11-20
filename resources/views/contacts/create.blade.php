@extends('layouts.app')

@section('title', 'Контакти')

@section('content')
    <h1>Форма за контакт</h1>

    <form method="POST" action="{{ route('contacts.store') }}" class="card card-body">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Име</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Имейл</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Съобщение</label>
            <textarea id="message" name="message" rows="3" class="form-control">{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Изпрати</button>
    </form>
@endsection

@extends('layouts.app')

@section('title', 'Нова статия')

@section('content')
    <h1>Нова статия</h1>
    <p class="text-muted">Изпратете формата празна, за да видите съобщенията за грешка на български.</p>

    {{-- Всички грешки наведнъж (слайд 33) --}}
    @if ($errors->any())
        <ul class="alert alert-danger ps-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('articles.store') }}" class="card card-body">
        @csrf

        {{-- old() + клас при грешка + съобщение до полето (слайдове 33-34) --}}
        <div class="mb-3">
            <label for="title" class="form-label">Заглавие</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
                   class="form-control @error('title') is-invalid @enderror">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Текст</label>
            <textarea id="body" name="body" rows="4"
                      class="form-control @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
            @error('body')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Провери</button>
    </form>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Лекция 5') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand bg-dark navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Лекция 5</a>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('tasks.index') }}">Задачи</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contacts.create') }}">Контакти</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('surveys.create') }}">Анкета</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('articles.create') }}">Статия</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('members.index') }}">Членове</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">
        {{-- Съобщението за успех е веднъж в layout-а - всеки контролер може да върне ->with('success', ...) (слайд 29) --}}
        @session('success')
            <div class="alert alert-success">{{ $value }}</div>
        @endsession

        @yield('content')
    </main>
</body>
</html>

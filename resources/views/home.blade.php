@extends('layouts.app')

@section('title', 'Начало')

@section('content')
    <h1 class="mb-4">Примери от лекция 5 - контролери и потребителски вход</h1>

    <div class="list-group">
        <a class="list-group-item list-group-item-action" href="{{ route('tasks.index') }}">
            <strong>Задачи</strong> - данни от контролера към изглед (слайд 8)
        </a>
        <a class="list-group-item list-group-item-action" href="{{ route('contacts.create') }}">
            <strong>Контакти</strong> - Request в контролер, зареждане на изглед с входа (слайдове 17-19, 27)
        </a>
        <a class="list-group-item list-group-item-action" href="{{ route('surveys.create') }}">
            <strong>Анкета</strong> - input(), integer(), boolean(), string(), has(), filled(), масиви (слайдове 20-22)
        </a>
        <a class="list-group-item list-group-item-action" href="{{ route('articles.create') }}">
            <strong>Статия</strong> - $request->validate(), @@error, old(), is-invalid (слайдове 30-34)
        </a>
        <a class="list-group-item list-group-item-action" href="{{ route('members.index') }}">
            <strong>Членове</strong> - FormRequest, service клас, ресурсен контролер, route model binding (слайдове 13, 36-51)
        </a>
        <a class="list-group-item list-group-item-action" href="{{ route('members.export') }}">
            <strong>Експорт на членовете (CSV)</strong> - контролер с едно действие __invoke (слайд 14)
        </a>
    </div>
@endsection

<?php

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('home page lists the examples', function () {
    $this->get(route('home'))->assertOk()->assertSee('Примери от лекция 5');
});

test('tasks index shows all tasks', function () {
    $task = Task::factory()->create(['title' => 'Да прочета лекция 5']);

    $this->get(route('tasks.index'))->assertOk()->assertSee($task->title);
});

test('contact form shows the submitted data', function () {
    $this->post(route('contacts.store'), [
        'name' => 'Петър',
        'email' => 'petar@abv.bg',
    ])
        ->assertOk()
        ->assertSee('petar@abv.bg')
        ->assertSee('Няма съобщение');
});

test('survey result shows how each request method reads the input', function () {
    $this->post(route('surveys.store'), [
        'name' => 'петър петров',
        'cities' => ['Варна', 'София'],
        'newsletter' => 'on',
        'per_page' => '20',
        'comment' => '',
    ])
        ->assertOk()
        ->assertSee('Петър Петров')
        ->assertSee('Варна, София')
        ->assertViewHas('wantsNewsletter', true)
        ->assertViewHas('perPage', 20)
        ->assertViewHas('hasComment', true)
        ->assertViewHas('filledComment', false);
});

test('survey without checked cities gets an empty array', function () {
    $this->post(route('surveys.store'), ['name' => 'Петър'])
        ->assertOk()
        ->assertViewHas('cities', [])
        ->assertViewHas('wantsNewsletter', false)
        ->assertViewHas('hasComment', false);
});

test('article validation returns bulgarian errors and the old input', function () {
    $this->from(route('articles.create'))
        ->post(route('articles.store'), ['title' => 'Заглавие', 'body' => ''])
        ->assertRedirect(route('articles.create'))
        ->assertSessionHasErrors('body')
        ->assertSessionHasInput('title', 'Заглавие');
});

test('article form marks the invalid field after a failed validation', function () {
    $this->followingRedirects()
        ->from(route('articles.create'))
        ->post(route('articles.store'), ['title' => 'Заглавие', 'body' => ''])
        ->assertOk()
        ->assertSee('value="Заглавие"', false)
        ->assertSee('is-invalid', false)
        ->assertSee('Полето');
});

test('valid article redirects back with a success message', function () {
    $this->post(route('articles.store'), [
        'title' => 'Контролери в Laravel',
        'body' => 'Контролерът трябва да е тънък.',
    ])
        ->assertRedirect(route('articles.create'))
        ->assertSessionHas('success');
});

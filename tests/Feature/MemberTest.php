<?php

use App\Mail\WelcomeMail;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('members index lists members', function () {
    $member = Member::factory()->create(['name' => 'Петър Петров']);

    $this->get(route('members.index'))
        ->assertOk()
        ->assertSee($member->name);
});

test('storing a member saves it, sends a welcome mail and redirects with a message', function () {
    Mail::fake();

    $this->post(route('members.store'), [
        'name' => 'Петър Петров',
        'email' => 'petar@abv.bg',
    ])
        ->assertRedirect(route('members.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('members', ['email' => 'petar@abv.bg']);
    Mail::assertSent(WelcomeMail::class, fn (WelcomeMail $mail): bool => $mail->hasTo('petar@abv.bg'));
});

test('storing a member ignores fields that are not in the rules', function () {
    Mail::fake();

    $this->post(route('members.store'), [
        'name' => 'Петър Петров',
        'email' => 'petar@abv.bg',
        'id' => 999,
    ])->assertRedirect(route('members.index'));

    expect(Member::first()->id)->not->toBe(999);
});

test('storing a member requires a unique email', function () {
    Member::factory()->create(['email' => 'petar@abv.bg']);

    $this->from(route('members.create'))
        ->post(route('members.store'), ['name' => 'Петър Петров', 'email' => 'petar@abv.bg'])
        ->assertRedirect(route('members.create'))
        ->assertSessionHasErrors(['email' => 'Този имейл вече е регистриран.']);

    expect(Member::count())->toBe(1);
});

test('storing a member validates the name', function () {
    $this->post(route('members.store'), ['name' => 'П', 'email' => 'petar@abv.bg'])
        ->assertSessionHasErrors(['name' => 'Името трябва да е поне 3 знака.']);
});

test('updating a member keeps their own email valid', function () {
    $member = Member::factory()->create(['email' => 'petar@abv.bg']);

    $this->put(route('members.update', $member), [
        'name' => 'Петър Георгиев',
        'email' => 'petar@abv.bg',
    ])->assertRedirect(route('members.index'));

    expect($member->fresh()->name)->toBe('Петър Георгиев');
});

test('updating a member rejects an email of another member', function () {
    Member::factory()->create(['email' => 'georgi@abv.bg']);
    $member = Member::factory()->create(['email' => 'petar@abv.bg']);

    $this->put(route('members.update', $member), [
        'name' => 'Петър Петров',
        'email' => 'georgi@abv.bg',
    ])->assertSessionHasErrors('email');

    expect($member->fresh()->email)->toBe('petar@abv.bg');
});

test('showing a missing member returns 404', function () {
    $this->get(route('members.show', 12345))->assertNotFound();
});

test('destroying a member deletes it', function () {
    $member = Member::factory()->create();

    $this->delete(route('members.destroy', $member))
        ->assertRedirect(route('members.index'));

    $this->assertModelMissing($member);
});

test('members export downloads a csv file', function () {
    Member::factory()->create(['name' => 'Петър Петров', 'email' => 'petar@abv.bg']);

    $response = $this->get(route('members.export'))->assertOk();

    expect($response->headers->get('content-disposition'))->toContain('members.csv')
        ->and($response->streamedContent())->toContain('petar@abv.bg');
});

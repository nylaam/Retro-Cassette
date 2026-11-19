<?php

use App\Models\Track;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('tamu diarahkan ke login saat membuka rak', function () {
    $this->get(route('shelf.index'))
        ->assertRedirect(route('login'));
});

test('rak hanya menampilkan kaset sendiri dengan yang terbaru di depan', function () {
    $user = User::factory()->create();
    $orangLain = User::factory()->create();

    $user->cassettes()->create(['title' => 'Kaset lama', 'color' => 'coral']);
    $user->cassettes()->create(['title' => 'Kaset baru', 'color' => 'teal']);
    $orangLain->cassettes()->create(['title' => 'Punya orang lain', 'color' => 'purple']);

    $this->actingAs($user)
        ->get(route('shelf.index'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('Shelf')
            ->has('cassettes', 2)
            ->where('cassettes.0.title', 'Kaset baru')
            ->where('cassettes.1.title', 'Kaset lama'));
});

test('rak menampilkan jumlah lagu tiap kaset', function () {
    $user = User::factory()->create();
    $kaset = $user->cassettes()->create(['title' => 'Kaset isi', 'color' => 'coral']);
    $kaset->tracks()->create(['title' => 'Lagu 1', 'artist' => 'Artis', 'source_id' => 'abc123']);
    $kaset->tracks()->create(['title' => 'Lagu 2', 'artist' => 'Artis', 'source_id' => 'def456']);

    $this->actingAs($user)
        ->get(route('shelf.index'))
        ->assertInertia(fn (Assert $page) => $page
            ->where('cassettes.0.tracks_count', 2));
});

test('judul lebih dari 40 karakter ditolak', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('cassettes.store'), [
            'title' => str_repeat('a', 41),
            'color' => 'coral',
        ])
        ->assertSessionHasErrors('title');

    expect($user->cassettes()->count())->toBe(0);
});

test('pemilik bisa membuka halaman edit kasetnya', function () {
    $user = User::factory()->create();
    $kaset = $user->cassettes()->create(['title' => 'Lagu galau', 'color' => 'coral']);

    $this->actingAs($user)
        ->get(route('cassettes.edit', $kaset))
        ->assertInertia(fn (Assert $page) => $page
            ->component('CassetteForm')
            ->where('cassette.title', 'Lagu galau')
            ->where('cassette.color', 'coral'));
});

test('pemilik bisa mengubah kasetnya', function () {
    $user = User::factory()->create();
    $kaset = $user->cassettes()->create(['title' => 'Lagu galau', 'color' => 'coral']);

    $this->actingAs($user)
        ->put(route('cassettes.update', $kaset), [
            'title' => 'Lagu semangat',
            'color' => 'teal',
            'note' => 'Buat pagi hari',
        ])
        ->assertRedirect(route('shelf.index'));

    $kaset->refresh();

    expect($kaset->title)->toBe('Lagu semangat');
    expect($kaset->color)->toBe('teal');
    expect($kaset->note)->toBe('Buat pagi hari');
});

test('menghapus kaset ikut menghapus lagu di dalamnya', function () {
    $user = User::factory()->create();
    $kaset = $user->cassettes()->create(['title' => 'Lagu galau', 'color' => 'coral']);
    $kaset->tracks()->create(['title' => 'Lagu 1', 'artist' => 'Artis', 'source_id' => 'abc123']);

    $this->actingAs($user)
        ->delete(route('cassettes.destroy', $kaset))
        ->assertRedirect(route('shelf.index'));

    expect($user->cassettes()->count())->toBe(0);
    expect(Track::count())->toBe(0);
});

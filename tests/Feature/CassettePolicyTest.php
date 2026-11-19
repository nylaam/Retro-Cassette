<?php

use App\Models\User;

test('user lain tidak bisa ubah atau hapus kaset orang', function () {
    $pemilik = User::factory()->create();
    $orangLain = User::factory()->create();
    $kaset = $pemilik->cassettes()->create(['title' => 'Lagu galau', 'color' => 'coral']);

    $this->actingAs($orangLain)
        ->put(route('cassettes.update', $kaset), ['title' => 'Dibajak', 'color' => 'teal'])
        ->assertForbidden();

    $this->actingAs($orangLain)
        ->delete(route('cassettes.destroy', $kaset))
        ->assertForbidden();

    expect($kaset->fresh()->title)->toBe('Lagu galau');
});

test('user lain tidak bisa membuka halaman edit kaset orang', function () {
    $pemilik = User::factory()->create();
    $orangLain = User::factory()->create();
    $kaset = $pemilik->cassettes()->create(['title' => 'Lagu galau', 'color' => 'coral']);

    $this->actingAs($orangLain)
        ->get(route('cassettes.edit', $kaset))
        ->assertForbidden();
});

test('kaset privat hanya bisa dilihat pemilik, kaset publik bisa dilihat user lain', function () {
    $pemilik = User::factory()->create();
    $orangLain = User::factory()->create();
    $privat = $pemilik->cassettes()->create(['title' => 'Privat', 'color' => 'coral']);
    $publik = $pemilik->cassettes()->create(['title' => 'Publik', 'color' => 'teal', 'visibility' => 'public']);

    expect($pemilik->can('view', $privat))->toBeTrue();
    expect($orangLain->can('view', $privat))->toBeFalse();
    expect($orangLain->can('view', $publik))->toBeTrue();
});

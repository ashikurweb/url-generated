<?php

use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can list urls', function () {
    Url::create([
        'original_url' => 'https://google.com',
        'short_code' => 'google',
    ]);

    $response = $this->getJson('/api/urls');

    $response->assertStatus(200)
             ->assertJsonCount(1);
});

test('can create a short url automatically', function () {
    $response = $this->postJson('/api/urls', [
        'original_url' => 'https://laravel.com',
    ]);

    $response->assertStatus(201)
             ->assertJsonStructure(['id', 'short_code', 'original_url']);
    
    $this->assertDatabaseHas('urls', [
        'original_url' => 'https://laravel.com',
    ]);
});

test('can create a short url with custom code', function () {
    $response = $this->postJson('/api/urls', [
        'original_url' => 'https://vuejs.org',
        'short_code' => 'vue',
    ]);

    $response->assertStatus(201)
             ->assertJsonFragment(['short_code' => 'vue']);
});

test('can redirect to original url', function () {
    $url = Url::create([
        'original_url' => 'https://tailwindcss.com',
        'short_code' => 'tw',
    ]);

    $response = $this->get('/tw');

    $response->assertRedirect('https://tailwindcss.com');
    
    $url->refresh();
    expect($url->clicks)->toBe(1);
});

test('404 for non-existent short code', function () {
    $response = $this->get('/non-existent');
    $response->assertStatus(404);
});

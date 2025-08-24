<?php

use App\Livewire\DisplayManagement;
use App\Models\User;
use Livewire\Livewire;

test('display management component can be rendered', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    Livewire::test(DisplayManagement::class)
        ->assertStatus(200);
});

test('display management shows displays from database', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    Livewire::test(DisplayManagement::class)
        ->assertSee('Display Management')
        ->assertSee('Online')
        ->assertSee('Offline')
        ->assertSee('Total');
});

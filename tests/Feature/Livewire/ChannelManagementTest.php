<?php

namespace Tests\Feature\Livewire;

use Livewire\Volt\Volt;
use Tests\TestCase;

class ChannelManagementTest extends TestCase
{
    public function test_it_can_render(): void
    {
        $component = Volt::test('channel-management');

        $component->assertSee('');
    }
}

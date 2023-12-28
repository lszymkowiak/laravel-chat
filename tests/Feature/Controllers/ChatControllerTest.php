<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ChatControllerTest extends TestCase
{
    /** @test */
    public function it_returns_chat_index()
    {
        User::factory()->count(3)->create();

        $this
            ->actingAs($this->user)
            ->get(route('chat.index'))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('users', 3)
                ->has('chats', 0));
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use app\Models\User;
use Laravel\Sanctum\Sanctum;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_login()
    {
        $user = User::factory()->createOne();

        $data = [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'testing',
        ];

        $this->postJson(route('auth.login'), $data)
            ->assertOk()
            ->assertJsonFragment(['access_token', 'user']);
    }

    public function test_user_can_register()
    {
        $data = [
            'name' => 'Tester',
            'email' => 'tester@email',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->postJson(route('auth.register'), $data)
            ->assertCreated()
            ->assertJsonFragment(['email' => $data['email']]);
    }

    public function test_user_can_see_their_profile()
    {
        $user = User::factory()->createOne();

        Sanctum::actingAs($user);

        $this->getJson(route('auth.profile'))
            ->assertOk()
            ->assertJsonFragment(['email' => $user->email]);
    }

    public function test_user_cannot_see_their_profile_when_unauthenticated()
    {
        $this->getJson(route('auth.profile'))->assertUnauthorized();
    }
    
    public function test_user_can_logout()
    {
        $user = User::factory()->createOne();

        Sanctum::actingAs($user);

        $this->getJson(route('auth.logout'))->assertOk();
    }
}

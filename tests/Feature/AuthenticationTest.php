<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    // ini e jangan lupa di use
    use RefreshDatabase;


//LOGIN//
    public function test_user_can_login() 
    {
        $user = User::factory()->createOne();

        $data = [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'testing',
        ];

        // ini bagian testing
        $this->postJson(route('auth.login'), $data)
            // assertOk() itu buat memastikan kalo respon yang didapat 200, memastikan hasil yang kita terima sesuai dengan hasil yang kita minta
            ->assertOk()
            // assertJsonStructure() itu memastikan di responnya ada 'access_token', 'user'
            ->assertJsonStructure(['access_token', 'user']);
    }
//LOGIN//

//REGISTER//
    public function test_user_can_register()
    {
        $data = [
            'name' => 'tester',
            'email' => 'tester@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->postJson(route('auth.register'), $data)
            ->assertCreated()
            ->assertJsonFragment(['email' => $data['email']]);
    }
//REGISTER//

//SEE PROFILE//
    public function test_user_can_see_their_profile()
    {
        $user = User::factory()->createOne();

        Sanctum::actingAs($user);

        $this->getJson(route('auth.profile'))
            ->assertOk()
            ->assertJsonFragment(['email' => $user->email]);
    }
//SEE PROFILE//

//CANNOT SEE PROFILE//
    public function test_user_cannot_see_their_profile_when_unauthenticated()
    {
        $this->getJson(route('auth.profile'))->assertUnauthorized();
    }
//CANNOT SEE PROFILE//

//LOGOUT//
    public function test_user_can_logout()
    {
        $user = User::factory()->createOne();

        Sanctum::actingAs($user);

        $this->getJson(route('auth.logout'))->assertOk();
    }
//LOGOUT//
}

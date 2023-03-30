<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Resto;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class RestoTest extends TestCase
{
    use RefreshDatabase;

//LIST RESTO
    public function test_user_can_list_all_resto()
    {
        $count = 5;
        Resto::factory()->count($count)->create();

        $user = User::factory()->createOne();
        Sanctum::actingAs($user);

        $this->getJson(route('restos.index'))
            ->assertOk()
            ->assertJsonCount($count);
    }
//LIST RESTO

//CREATE RESTO
    public function test_user_can_create_resto()
    {
        $data = Resto::factory()->makeOne()->toArray();

        $user = User::factory()->createOne();
        Sanctum::actingAs($user);

        $this->postJson(route('restos.store'), $data)->assertCreated();
    }
//CREATE RESTO

//SHOW RESTO
    public function test_user_can_show_resto()
    {
        $data = Resto::factory()->createOne();
        
        $user = User::factory()->createOne();
        Sanctum::actingAs($user);

        $this->getJson(route('restos.show', $data))
            ->assertOk()
            ->assertJsonStructure(['name', 'description', 'address']);
    }
//SHOW RESTO

//EDIT RESTO
    public function test_user_can_edit_resto()
    {
        // makeOne() tidak masuk ke database
        // createOne() masuk ke database
        $updatedData = Resto::factory()->makeOne()->toArray();
        $data = Resto::factory()->createOne();

        $user = User::factory()->createOne();
        Sanctum::actingAs($user);

        $this->patchJson(route('restos.update', $data), $updatedData)
            ->assertOk()
            ->assertJsonStructure(['name', 'description', 'address']);
    }
//EDIT RESTO

//DELETE RESTO
    public function test_user_can_delete_resto()
    {
        $data = Resto::factory()->createOne();

        $user = User::factory()->createOne();
        Sanctum::actingAs($user);

        $this->deleteJson(route('restos.destroy', $data))
            ->assertOk()
            ->assertJsonStructure(['name', 'description', 'address']);
    }
//DELETE RESTO
}

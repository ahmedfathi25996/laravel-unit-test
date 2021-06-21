<?php

namespace Tests\Feature\APIs;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_profile_it_should_return_401_if_user_not_authenticated()
    {
        $this->json('GET', 'api/get/profile')
            ->assertStatus(401)->assertJsonFragment(["message" => "Unauthenticated."]);
    }

    public function test_get_profile_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->json('GET', 'api/get/profile')
            ->assertOk()->assertJsonFragment(["Status"=> 1,"first_name"=> $user->first_name,"last_name"=>$user->last_name]);
    }



    public function test_required_fields_for_update_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $data = [];
        $this->json('POST', 'api/update/profile',$data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "first_name" => ["The first name field is required."],
                    "last_name" => ["The last name field is required."],
                    "gender" => ["The gender field is required."],
                ]
            ]);

    }

    public function test_update_profile_it_should_return_401_if_user_not_authenticated()
    {
        $data = [];
        $this->json('POST', 'api/update/profile',$data)
            ->assertStatus(401)->assertJsonFragment(["message" => "Unauthenticated."]);
    }

    public function test_update_profile_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $data = [
            "first_name" => "ahmed",
            "last_name" => "fathi",
            "gender" => "Male"
        ];
        $this->json('POST', 'api/update/profile',$data)
            ->assertCreated()->assertJsonStructure([
                "Status",
                "Message",
                "Data"=>[
                    "token",
                    "first_name",
                    "last_name",
                    "email",
                    "user_type"
                ],
                "Errors"
            ]);
    }


}

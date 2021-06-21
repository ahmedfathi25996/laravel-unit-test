<?php

namespace Tests\Feature\APIs;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_user_addresses_it_should_return_401_if_user_not_authunticated()
    {
        $this->json('GET', 'api/addresses')
            ->assertStatus(401)->assertJson(["message" => "Unauthenticated."]);
    }

    public function test_get_user_addresses_successfully()
    {
        $this->withoutExceptionHandling();
        $user =User::factory()->create();
        $this->actingAs($user);
        $address =Address::factory()->create([
            "user_id" => $user->id
        ]);
        $this->json('GET', 'api/addresses')
            ->assertOk()->assertJsonFragment([
                "lat" => $address->lat,
                "lng" => $address->lng,
                "street_name" => $address->street_name,
                "city" => $address->city
            ]);
    }

    public function test_add_user_addresses_it_should_return_401_if_user_not_authunticated()
    {
        $this->json('POST', 'api/addresses',[])
            ->assertStatus(401)->assertJson(["message" => "Unauthenticated."]);
    }

    public function test_required_fields_for_store_address()
    {
        $user =User::factory()->create();
        $this->actingAs($user);
        $data = [];
        $this->json('POST', 'api/addresses',$data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "lat" => ["The lat field is required."],
                    "lng" => ["The lng field is required."],
                ]
            ]);

    }

    public function test_address_saved_successfully()
    {
        $this->withoutExceptionHandling();
        $user =User::factory()->create();
        $this->actingAs($user);
        $data = [
            "lat" => "123",
            "lng" => "456",
            "street_name" => "makrm abid",
            "city" => "cairo",
        ];
        $this->json('POST', 'api/addresses',$data)
            ->assertCreated()
            ->assertJson([
                "Status" => 1,
                "Message" => "Address Added Successfully",
                "Data" => [
                    "lat" => "123",
                    "lng" => "456",
                    "street_name" => "makrm abid",
                    "city" => "cairo"
                ]
            ]);
    }

    public function test_get_single_address_it_should_return_401_if_user_not_authenticated()
    {
        $address = Address::factory()->create();
        $this->json('GET', "api/addresses/$address->id")
            ->assertStatus(401)->assertJson(["message" => "Unauthenticated."]);
    }

    public function test_get_single_address_it_should_return_error_if_address_not_exist()
    {
        $user =User::factory()->create();
        $this->actingAs($user);
        $address = Address::factory()->create();
        $this->json('GET', "api/addresses/0")
            ->assertJsonFragment(["Status" => 0,"Message"=> "This Address Is Not Exist"]);
    }


    public function test_get_single_address_successfully()
    {
        $this->withoutExceptionHandling();
        $user =User::factory()->create();
        $this->actingAs($user);
        $address =Address::factory()->create([
            "user_id" => $user->id
        ]);
        $this->json('GET', "api/addresses/$address->id")
            ->assertOk()->assertJsonFragment([
                "lat" => $address->lat,
                "lng" => $address->lng,
                "street_name" => $address->street_name,
                "city" => $address->city
            ]);
    }

    public function test_update_address_it_should_return_401_if_user_not_authenticated()
    {
        $address = Address::factory()->create();
        $this->json('PUT', "api/addresses/$address->id")
            ->assertStatus(401)->assertJson(["message" => "Unauthenticated."]);
    }

    public function test_required_fields_for_edit_address()
    {
        $user =User::factory()->create();
        $this->actingAs($user);
        $address = Address::factory()->create();
        $data = [];
        $this->json('PUT', "api/addresses/$address->id",$data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "lat" => ["The lat field is required."],
                    "lng" => ["The lng field is required."],
                ]
            ]);

    }

    public function test_update_address_it_should_return_error_if_address_not_exist()
    {
        $data = [
            "lat" => "123",
            "lng" => "456",
            "street_name" => "makrm abid",
            "city" => "cairo",
        ];
        $user =User::factory()->create();
        $this->actingAs($user);
        $address = Address::factory()->create();
        $this->json('PUT', "api/addresses/0",$data)
            ->assertJsonFragment(["Status" => 0,"Message"=> "This Address Is Not Exist"]);
    }

    public function test_update_address_successfully()
    {
        $data = [
            "lat" => "123",
            "lng" => "456",
            "street_name" => "makrm abid",
            "city" => "cairo",
        ];
        $user =User::factory()->create();
        $this->actingAs($user);
        $address = Address::factory()->create();
        $this->json('PUT', "api/addresses/$address->id",$data)
            ->assertJsonFragment([
                "Status" => 1,
                "Message" => "Address Updated Successfully",
                    ]
            );
    }

    public function test_delete_address_it_should_return_401_if_user_not_authenticated()
    {
        $address = Address::factory()->create();
        $this->json('DELETE', "api/addresses/$address->id")
            ->assertStatus(401)->assertJson(["message" => "Unauthenticated."]);
    }

    public function test_delete_address_it_should_return_error_if_address_not_exist()
    {
        $user =User::factory()->create();
        $this->actingAs($user);
        $address = Address::factory()->create();
        $this->json('DELETE', "api/addresses/0")
            ->assertJsonFragment(["Status" => 0,"Message"=> "This Address Is Not Exist"]);
    }

    public function test_delete_address_successfully()
    {
        $user =User::factory()->create();
        $this->actingAs($user);
        $address = Address::factory()->create();
        $this->json('DELETE', "api/addresses/$address->id")
            ->assertJsonFragment(["Status" => 1,"Message"=> "Address Deleted Successfully"]);
    }




}

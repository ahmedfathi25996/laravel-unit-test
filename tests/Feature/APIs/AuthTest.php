<?php

namespace Tests\Feature\APIs;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

    #region register
    public function test_required_fields_for_register()
    {
        $data = [];
        $this->json('POST', 'api/register',$data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "first_name" => ["The first name field is required."],
                    "last_name" => ["The last name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);

    }

    public function test_register_it_should_return_422_if_email_not_formated()
    {
        $data = User::factory()->make(["email"=> "test"]);
        $this->json('POST', 'api/register',$data->toArray())
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email must be a valid email address."],
                ]
            ]);
    }

    public function test_register_it_should_return_422_if_email_not_unique()
    {
        $user = User::factory()->create([
            "email" => "test@test.com"
        ]);
        $data = User::factory()->make(["email"=> "test@test.com"]);
        $this->json('POST', 'api/register',$data->toArray())
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email has already been taken."],
                ]
            ]);
    }

    public function test_register_it_should_return_422_if_password_is_less_than_6_characters()
    {
        $userData = [
            "first_name" => "ahmed",
            "last_name" => "fathi",
            "email" => "test@test.com",
            "password" => "123",
        ];
        $this->json('POST', 'api/register',$userData)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => ["The password must be at least 6 characters."],
                ]
            ]);
    }

    public function test_register_successfully()
    {
        $userData = [
            "first_name" => "ahmed",
            "last_name" => "fathi",
            "email" => "test@test.com",
            "password" => "123456",
        ];
        $this->json('POST', 'api/register',$userData)
            ->assertStatus(201)
            ->assertJsonFragment([
                "first_name" => "ahmed"
            ]);
    }

    #region login
    public function test_required_fields_for_login()
    {
        $data = [];
        $this->json('POST', 'api/login',$data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);

    }

    public function test_login_it_should_return_422_if_email_not_formated()
    {
        $data = User::factory()->make(["email"=> "test"]);
        $this->json('POST', 'api/login',$data->toArray())
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email must be a valid email address."],
                ]
            ]);
    }

    public function test_login_it_should_fail_if_has_wrong_email_or_password()
    {
        $user = User::factory()->create([
            "email" => "ahmed@ahmed.com",
            "password" => Hash::make("123456")
        ]);
        $data = [
            "email" => "ahmed@ahmed.com",
            "password" => "147258"
        ];
        $this->json('POST', 'api/login',$data)
            ->assertJsonFragment([
                "Message" => "Invalid Email Or Password",
               "Status" => 0
            ]);
    }

    public function test_login_it_should_return_error_if_user_is_exist_but_not_activated()
    {
        $user = User::factory()->create([
            "email" => "ahmed@ahmed.com",
            "password" => Hash::make("123456"),
            "is_active" => 0
        ]);
        $data = [
            "email" => "ahmed@ahmed.com",
            "password" => "123456"
        ];
        $this->json('POST', 'api/login',$data)
            ->assertJsonFragment([
                "Message" => "Please Check Your Email For Activation",
                "Status" => 0
            ]);
    }

    public function test_login_is_success()
    {
        $user = User::factory()->create([
            "email" => "adham@adham.com",
            "password" => Hash::make("123456")
        ]);
        $data = [
            "email" => "adham@adham.com",
            "password" => "123456"
        ];
        $response = $this->post("api/login",$data);
        $response->assertJsonFragment(["Message" => "Logged in Successfully"]);
    }
    #endregion

    #region forget password
    public function test_required_fields_for_forget_password()
    {
        $data = [];
        $this->json('POST', 'api/forget_password',$data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email field is required."],
                ]
            ]);

    }


    public function test_forget_password_it_should_return_422_if_email_not_formated()
    {
        $data = User::factory()->make(["email"=> "test"]);
        $this->json('POST', 'api/forget_password',$data->toArray())
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email must be a valid email address."],
                ]
            ]);
    }

    public function test_forget_password_this_email_is_not_exist()
    {
        $user = User::factory()->create([
            "email" => "adham@adham.com"
        ]);
        $data = ["email" => "ahmed@ahmed.com"];
        $this->json('POST', 'api/forget_password',$data)
            ->assertJson([
                "Message" => "This User Is Not Exist",
                "Status" => 0
            ]);

    }

    public function test_forget_password_successfully()
    {
        $user = User::factory()->create([
            "email" => "ahmed@ahmed.com"
        ]);
        $data = ["email" => "ahmed@ahmed.com"];
        $this->json('POST', 'api/forget_password',$data)
            ->assertJson([
                "Message" => "Please Check Your Mail To Reset Your Password",
                "Status" => 1
            ]);
    }

    #endregion






}

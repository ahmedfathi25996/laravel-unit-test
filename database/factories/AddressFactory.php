<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'lat' => "123.1",
            'lng' => "145.96",
            "city" => "cairo",
            "street_name" => "test",
            "building" => "10",
            "floor" => "10",
            "aprt_no" => "10",
            "mobile_number" => "01146899869",
            "address_name" => "home",
            "additional_directions" => "notes"
        ];
    }


}

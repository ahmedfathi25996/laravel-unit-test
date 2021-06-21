<?php

namespace Database\Factories;

use App\Models\Langs;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LangsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Langs::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => "arabic",
            'lang_code' => "ar",
            'image' => null,
        ];
    }


}

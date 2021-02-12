<?php

namespace Database\Factories;

use App\Models\CustomEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomEmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomEmail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email,
            'body' => $this->faker->text,
            'subject' => $this->faker->text(50),
            'attachments' =>  []
        ];
    }
}

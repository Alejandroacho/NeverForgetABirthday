<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'message' => $this->faker->paragraph($nb = 3, $asText = false),
            'birthday' => $this->faker->date(),
            'user_id' => $this->faker->randomDigitNot(0)
        ];
    }
}

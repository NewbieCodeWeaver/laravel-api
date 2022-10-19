<?php

namespace Database\Factories;

use App\Models\partida;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class partidaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = partida::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'valor_dado1' => $valor_dado1 = $this->faker->numberBetween(1, 7),
            'valor_dado2' => $valor_dado2 = $this->faker->numberBetween(1, 7),
            'resultado' => $valor_dado1 + $valor_dado2,
        ];
    }
}

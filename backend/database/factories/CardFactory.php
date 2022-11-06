<?php

namespace Database\Factories;

use App\Models\Board;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'board_id' => Board::factory(),
            'index' => 0,
            'title' => 'factory title card',
            'description' => 'factory desc card'
        ];
    }
}

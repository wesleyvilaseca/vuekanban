<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Board::class;
    public function definition()
    {
        return [
            'title' => 'factory board',
            'project_id' => Project::factory()
        ];
    }
}

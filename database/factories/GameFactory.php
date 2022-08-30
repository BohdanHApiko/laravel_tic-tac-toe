<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'board_state' => [
                ['', '', ''],
                ['', '', ''],
                ['', '', '']
            ],
            'current_turn' => 'x',
            'winner' => '',
            'score_x' => 0,
            'score_o' => 0
        ];
    }
}

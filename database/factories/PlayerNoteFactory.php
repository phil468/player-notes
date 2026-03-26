<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlayerNote>
 */
class PlayerNoteFactory extends Factory
{
    protected $model = PlayerNote::class;

    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'user_id' => User::factory(),
            'note' => fake()->sentence(),
        ];
    }
}

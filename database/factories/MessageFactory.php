<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'chat_id' => $this->getChatId(),
            'user_id' => User::inRandomOrder()->first()->id,
            'text' => $this->faker->text,
        ];
    }

    /**
     * Get chat id.
     * 
     * @return int
     */
    public function getChatId(): int
    {
        $maxId = Message::orderBy('chat_id', 'DESC')->first()->chat_id ?? 1;

        if (Message::where('chat_id', $maxId)->count() >= 2) {
            return $maxId + 1;
        }

        return $maxId;
    }
}

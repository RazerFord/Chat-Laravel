<?php

namespace App\Listeners;

use App\Events\ChatCreate as event;
use App\Models\Chat;
use App\Models\User;
use App\Models\UserChat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChatCreate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ChatCreate  $event
     * @return void
     */
    public function handle(event $event)
    {
        $chat = Chat::create();

        foreach ($event->userIds as $id) {
            UserChat::create([
                'user_id' => $id,
                'chat_id' => $chat->id
            ]);
        }

        return $chat->toArray();
    }
}

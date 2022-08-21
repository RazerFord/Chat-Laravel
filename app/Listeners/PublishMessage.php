<?php

namespace App\Listeners;

use App\Events\PublishMessage as Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use phpcent\Client;

class PublishMessage
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
     * @param  \App\Events\PublishMessage  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $client = new Client(
            config('centrifugo.url'),
            env('CENTRIFUGO_API_KEY'),
            env('CENTRIFUGO_TOKEN_HMAC_SECRET_KEY')
        );

        $data = [
            'name' => $event->message->user->name,
            'text' => $event->message->text,
            'created_at' => $event->message->created_at->format('Y.m.d H:i')
        ];

        $client->publish('chat#' . $event->message->chat_id, $data);
    }
}

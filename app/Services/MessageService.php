<?php

namespace App\Services;

use App\Events\PublishMessage;
use App\Models\Chat;
use App\Models\Friend;
use App\Models\Message;
use App\Models\User;
use App\Models\UserChat;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use phpcent\Client;

class MessageService implements ServiceInterface
{
    /**
     * @var User $user
     */
    public User $user;

    /**
     * Initialize user.
     * 
     * @return void
     */
    public function instance(): void
    {
        $this->user = Auth::user();
    }

    /**
     * Get users with last message.
     * 
     * @return Collection
     */
    public function lastSingleMessages(): Collection
    {
        $this->instance();

        $lastSingleMessages = Friend::where('friends.user_id', $this->user->id)
            ->join('messages', 'friends.latest_message_id', '=', 'messages.id')
            ->join('chats', 'friends.chat_id', '=', 'chats.id')
            ->join('user_chats', 'chats.id', '=', 'user_chats.chat_id')
            ->join('users', 'user_chats.user_id', '=', 'users.id')
            ->select(
                'friends.user_id as user_id',
                'user_chats.user_id as companion_id',
                'users.name as name',
                'friends.chat_id as chat_id',
                'single',
                'chats.name as chat_name',
                'latest_message_id',
                'text',
                'messages.created_at as created_at'
            )
            ->where('chats.single', true)
            ->where('user_chats.user_id', '<>', $this->user->id)
            ->distinct()
            ->get();

        return $lastSingleMessages;
    }

    public function lastNotSingleMessages(): Collection
    {
        $this->instance();

        $lastNotSingleMessages = Friend::where('friends.user_id', $this->user->id)
            ->join('messages', 'friends.latest_message_id', '=', 'messages.id')
            ->join('chats', 'friends.chat_id', '=', 'chats.id')
            ->select(
                'friends.user_id as user_id',
                'friends.chat_id as chat_id',
                'single',
                'chats.name as name',
                'latest_message_id',
                'text',
                'messages.created_at as created_at'
            )
            ->where('chats.single', false)
            ->get();

        return $lastNotSingleMessages;
    }

    /**
     * Get messages.
     * 
     * @param int $id
     * @return Collection
     */
    public function getMessagesOfChat(int $id): Collection
    {
        $messages = Message::where('chat_id', $id)
            ->join('users', 'messages.user_id', '=', 'users.id')
            ->select('users.name as name', 'messages.text as text', 'messages.created_at as created_at')
            ->get();

        return $messages;
    }

    /**
     * Get name of chat.
     * 
     * @param int $id
     * @return string
     */
    public function getNameOfChat(int $id): string
    {
        $chat = Chat::findOrFail($id);

        if (!$chat->single) {
            return $chat->name;
        }

        return UserChat::where('chat_id', $id)
            ->where('user_id', '<>', Auth::user()->id)
            ->first()
            ->user()
            ->firstOrFail()
            ->name;
    }

    /**
     * Get token for centrifugo.
     * 
     * @param int
     * @return string
     */
    public function getTokenForCentrifugo(int $id): string
    {
        $client = new Client(
            config('centrifugo.url'),
            env('CENTRIFUGO_API_KEY'),
            env('CENTRIFUGO_TOKEN_HMAC_SECRET_KEY')
        );

        return $client->generateConnectionToken($id);
    }

    /**
     * Get token auth.
     * 
     * @param int
     * @return string
     */
    public function getTokenAuth(): string
    {
        /**
         * @var User
         */
        $user = Auth::user();

        return $user->createToken(config('app.name'))->plainTextToken;
    }

    /**
     * Create a new message.
     * 
     * @param array
     * @return array
     */
    public function createMessage(array $data): array
    {
        if (Gate::denies('create-message', [$data])) {
            abort(403);
        }

        $data['user_id'] = Auth::user()->id;

        $message = Message::create($data);

        PublishMessage::dispatch($message);

        $userIds = UserChat::where('chat_id', $data['chat_id'])->get()->pluck('user_id');

        foreach ($userIds as $userId) {
            Friend::updateOrCreate(
                ['user_id' => $userId, 'chat_id' => $data['chat_id']],
                ['latest_message_id' => $message->id]
            );
        }
        return $message->toArray();
    }
}

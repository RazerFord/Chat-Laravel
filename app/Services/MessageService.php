<?php

namespace App\Services;

use App\Models\Friend;
use App\Models\User;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

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
    public function getMessages(int $id): Collection
    {
        $userId = Auth::user()->id;
        dd(1);
    }
}

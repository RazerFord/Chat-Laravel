<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserMessage;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class MessageService implements ServiceInterface
{
    /**
     * Get users with last message.
     * 
     * @return Collection
     */
    public function getLastMessages(): Collection
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        return $user->friends()->with('message:id,user_id,text', 'user:id,name')->get();
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
        UserMessage::whereIn('user_id', [$userId, $id])->get();
    }
}

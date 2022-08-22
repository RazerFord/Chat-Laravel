<?php

namespace App\Services;

use App\Events\ChatCreate;
use App\Models\Chat;
use App\Models\UserChat;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Support\Facades\Auth;

class UserChatService implements ServiceInterface
{
    /**
     * Create or return new chat.
     * 
     * @param array
     * @return array
     */
    public function createNewChatOrFirst(array $data): array
    {
        $ids = UserChat::where('user_id', Auth::user()->id)->get()->pluck('chat_id')->toArray();
        
        if (empty($ids)) {
            $chat = ChatCreate::dispatch([$data['user_id'], Auth::user()->id]);

            return $chat[0];
        }

        $userChats = UserChat::whereIn('chat_id', $ids)->where('user_id', $data['user_id'])->get();

        $userChatsIds = $userChats->pluck('chat_id');

        if (empty($userChatsIds->toArray())) {
            $chat = ChatCreate::dispatch([$data['user_id'], Auth::user()->id]);
            
            return $chat[0];
        }

        if ($userChatsIds->isEmpty()) {
            $chat = ChatCreate::dispatch([$data['user_id'], Auth::user()->id]);

            return $chat[0];
        }
        
        $chat = Chat::whereIn('id', $userChatsIds)->where('single', true)->first();

        if (empty($chat)) {
            $chat = ChatCreate::dispatch([$data['user_id'], Auth::user()->id]);

            return $chat[0];
        }

        return $chat->toArray();
    }
}

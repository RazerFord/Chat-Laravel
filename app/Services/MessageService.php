<?php

namespace App\Services;

use App\Models\Message;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageService implements ServiceInterface
{
    /**
     * Get users with last message.
     * 
     * @return array
     */
    public function getUsers(): array
    {
        $latestMessages = Message::select('chat_id', DB::raw('MAX(id) as id'))
            ->groupBy('chat_id')
            ->get()
            ->pluck('id')
            ->toArray();
            
        // dd(Auth::user()->id);
        if (empty($latestMessages)) {
            return [];
        }

        return Message::with('user:id,name')
            ->whereIn('id', $latestMessages)
            ->get()
            ->toArray();
    }
}

        // dd(Message::join('messages as alias', function ($join) {
        //     $join->on('messages.chat_id', '=', 'alias.chat_id')
        //         ->on('messages.id', '<', 'alias.id');
        // })->get());

// SELECT m1.*
// FROM messages m1 LEFT JOIN messages m2
//  ON (m1.name = m2.name AND m1.id < m2.id)
// WHERE m2.id IS NULL;

// $latestPosts = DB::table('posts')
//                    ->select('user_id', DB::raw('MAX(created_at) as last_post_created_at'))
//                    ->where('is_published', true)
//                    ->groupBy('user_id');
 
// $users = DB::table('users')
//         ->joinSub($latestPosts, 'latest_posts', function ($join) {
//             $join->on('users.id', '=', 'latest_posts.user_id');
//         })->get();
//https://laravel.com/docs/9.x/queries#subquery-joins
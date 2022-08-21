<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friend extends Model
{
    use HasFactory;

    protected $table = 'friends';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'chat_id',
        'latest_message_id',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Return relationship on message.
     */
    public function message(): BelongsTo
    {
        return $this->BelongsTo(Message::class, 'latest_message_id', 'id');
    }

    /**
     * Return relationship on user.
     */
    public function chat(): BelongsTo
    {
        return $this->BelongsTo(Chat::class, 'chat_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Filters\User\UserFilter;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Return relationship on messages.
     * 
     * @return BelongsToMany
     */
    public function messages(): BelongsToMany
    {
        return $this->belongsToMany(Message::class);
    }

    /**
     * Return relationship on friends.
     * 
     * @return HasMany
     */
    public function friends(): HasMany
    {
        return $this->hasMany(Friend::class);
    }

        /**
     * Return relationship on chats.
     * 
     * @return BelongsToMany
     */
    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class);
    }

    /**
     * Filter course.
     * 
     * @param Request $request
     * @return Builder
     */
    public function getUserByFilter(Request $request): Builder
    {
        return (new UserFilter())->apply($request);
    }
}

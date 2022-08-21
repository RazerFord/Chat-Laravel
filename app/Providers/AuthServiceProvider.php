<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Chat;
use App\Models\User;
use App\Models\UserChat;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('create-message', function (User $user, array $message) {
            $userChat = new UserChat();
            
            return $userChat->where('user_id', $user->id)->where('chat_id', $message['chat_id'])->exists();
        });
    }
}

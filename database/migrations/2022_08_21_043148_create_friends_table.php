<?php

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained('users', 'id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(Chat::class)
                ->constrained('chats', 'id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(Message::class, 'latest_message_id')
                ->constrained('messages', 'id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unique(['user_id', 'chat_id']);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friends');
    }
};

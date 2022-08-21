<?php

namespace App\Http\Controllers\MessageControllers;

use App\Http\Controllers\BaseController;
use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class MessageController extends BaseController
{
    /**
     * Initialize class of service.
     * 
     * @param AuthService
     * @return void
     */
    public function __construct(MessageService $service)
    {
        $this->service = $service;
    }

    /**
     * Index messages of user.
     * 
     * @return View|Factory
     */
    public function index(): View|Factory
    {
        $lastSingleMessages = $this->service->lastSingleMessages() ?? collect([]);

        $lastNotSingleMessages = $this->service->lastNotSingleMessages() ?? collect(['naem' => 1]);

        $lastMessages = collect()->merge($lastNotSingleMessages)->merge($lastSingleMessages)->sortByDesc('created_at');

        return view('messages', compact('lastMessages'));
    }

    /**
     * Show messages of user.
     * 
     * @return View|Factory
     */
    public function show(int $id): View|Factory
    {
        $lastMessages = $this->service->getLastMessages();

        $messages = $this->service->getMessages($id);

        return view('messages', compact('lastMessages'));
    }
}

<?php

namespace App\Http\Controllers\MessageControllers;

use App\Http\Controllers\BaseController;
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
        $users = $this->service->getUsers();

        return view('message', compact('users'));
    }
}

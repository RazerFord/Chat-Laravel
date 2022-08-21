<?php

namespace App\Http\Controllers\MessageControllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Message\StoreFormRequest;
use App\Responses\SuccessResponse;
use App\Services\MessageService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

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
        $lastSingleMessages = $this->service->lastSingleMessages() ?? collect([]);

        $lastNotSingleMessages = $this->service->lastNotSingleMessages() ?? collect(['naem' => 1]);

        $lastMessages = collect()->merge($lastNotSingleMessages)->merge($lastSingleMessages)->sortByDesc('created_at');

        $messages = $this->service->getMessagesOfChat($id);

        $name = $this->service->getNameOfChat($id);

        $token = $this->service->getTokenForCentrifugo($id);

        $tokenAuth = $this->service->getTokenAuth();

        return view('messages', compact('lastMessages', 'messages', 'name', 'token', 'tokenAuth'));
    }

    /**
     * Store new message.
     * 
     * @param StoreFormRequest
     * @return JsonResponse
     */
    public function store(StoreFormRequest $request)
    {
        $answer = $this->service->createMessage($request->validated());

        return SuccessResponse::response(JsonResponse::$statusTexts[JsonResponse::HTTP_CREATED], $answer, JsonResponse::HTTP_CREATED);
    }
}

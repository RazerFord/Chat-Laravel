<?php

namespace App\Http\Controllers\UserChatControllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\UserChat\StoreFormRequest;
use App\Responses\SuccessResponse;
use App\Services\UserChatService;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserChatController extends BaseController
{
    /**
     * Initialize class of service.
     * 
     * @param AuthService
     * @return void
     */
    public function __construct(UserChatService $service)
    {
        $this->service = $service;
    }

    /**
     * Store new user-chat.
     * 
     * @param StoreFormRequest
     * @return JsonResponse
     */
    public function store(StoreFormRequest $request):JsonResponse
    {
        $answer = $this->service->createNewChatOrFirst($request->validated());

        return SuccessResponse::response(JsonResponse::$statusTexts[JsonResponse::HTTP_CREATED], $answer, JsonResponse::HTTP_CREATED);
    }
}

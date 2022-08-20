<?php

namespace App\Http\Controllers\ChatControllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends BaseController
{
    public function index()
    {
        return view('chat');
    }
}

<?php

namespace App\Http\Controllers\MessageControllers;

use App\Http\Controllers\BaseController;

class MessageController extends BaseController
{
    public function index()
    {
        return view('message');
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Class of service.
     * 
     * @var ServiceInterface $service Class of service
     */
    protected $service;
}

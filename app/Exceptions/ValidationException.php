<?php

namespace App\Exceptions;

use App\Responses\ErrorResponse;
use Exception;
use Throwable;

class ValidationException extends Exception
{
    /**
     * @var array|null $errors Errors
     */
    protected $errors;

    public function __construct(string $message, array|null $errors = null, int $code = 422, Throwable|null $previous = null)
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Render response page
     * 
     * @return JsonResponse
     */
    public function render()
    {
        return ErrorResponse::response($this->message, $this->errors, $this->code);
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;
use Throwable;

class ApiPostRequestException extends Exception
{
    private $messages;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->messages = null;
    }

    public function messages() {
        return $this->messages;
    }

    public static function fromResponse(Response $response) {
        $exception = new ApiPostRequestException();
        $exception->messages = $response->json()['messages'] ?? null;
        return $exception;
    }
}

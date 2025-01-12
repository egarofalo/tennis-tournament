<?php

namespace App\Exceptions;

use Exception;

class InvalidGenderIdFromRequestException extends Exception
{
    /** @var int http status code */
    protected $statusCode;

    public function __construct(
        string $message = "Invalid gender id received from request object",
        int $statusCode = 422
    ) {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }
}

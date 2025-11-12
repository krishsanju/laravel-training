<?php

namespace App\Exceptions;

use Exception;

class ResetCodeException extends Exception
{
    protected $status;

    public function __construct(string $message = "Invalid reset code", int $status = 400)
    {
        parent::__construct($message, $status);
        $this->status = $status;
    }

    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->status);
    }
}

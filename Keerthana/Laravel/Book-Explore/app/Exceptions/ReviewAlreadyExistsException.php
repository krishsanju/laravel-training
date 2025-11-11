<?php

namespace App\Exceptions;

use Exception;

class ReviewAlreadyExistsException extends Exception
{
    protected $message = 'Review already exists for this book.';
}

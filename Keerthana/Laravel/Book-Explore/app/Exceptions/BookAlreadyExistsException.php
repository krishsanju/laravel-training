<?php

namespace App\Exceptions;

use Exception;

class BookAlreadyExistsException extends Exception
{
    protected $message = 'Book already exists.';
}

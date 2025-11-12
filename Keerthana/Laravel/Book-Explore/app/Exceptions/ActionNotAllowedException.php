<?php

namespace App\Exceptions;

use Exception;

class ActionNotAllowedException extends Exception
{
    protected $message = 'Action not allowed.';
}

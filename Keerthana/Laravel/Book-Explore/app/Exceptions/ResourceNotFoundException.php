<?php

namespace App\Exceptions;

use Exception;

class ResourceNotFoundException extends Exception
{
    public function __construct(string $resource = 'Resource')
    {
        parent::__construct("{$resource} not found.");
    }
}

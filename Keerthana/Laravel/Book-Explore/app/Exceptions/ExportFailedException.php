<?php

namespace App\Exceptions;

use Exception;

class ExportFailedException extends Exception
{
    protected $message = 'Export failed due to internal error.';
}

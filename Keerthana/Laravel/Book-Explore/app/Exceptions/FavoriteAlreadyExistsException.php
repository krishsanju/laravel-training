<?php

namespace App\Exceptions;

use Exception;

class FavoriteAlreadyExistsException extends Exception
{
    protected $message = 'Book is already in favorites.';
}

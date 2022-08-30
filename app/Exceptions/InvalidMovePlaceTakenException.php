<?php

namespace App\Exceptions;

use Exception;

class InvalidMovePlaceTakenException extends Exception
{
    public function render($request)
    {
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Can\'t place here. Spot already taken'], 409);
        }
    }
}

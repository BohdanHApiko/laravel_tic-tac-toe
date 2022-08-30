<?php

namespace App\Exceptions;

use Exception;

class OutOfTurnMoveException extends Exception
{
    public function render($request)
    {
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Not your turn'], 406);
        }
    }
}

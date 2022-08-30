<?php

namespace App\Services;

use App\Models\Board;
use App\Interfaces\BoardServiceInterface;

class BoardService implements BoardServiceInterface
{
    protected $defaultBoardState = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];

    public function getInitState(): array
    {
        return $this->defaultBoardState;
    }

    public function checkIfWon(array $board): bool
    {
        return false;
    }
}
<?php

namespace App\Interfaces;

interface BoardServiceInterface
{
    public function getInitState(): array;

    public function checkIfWon(array $board): bool;
}
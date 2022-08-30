<?php

namespace App\Interfaces;

interface BoardServiceInterface
{
    public function getInitState(): array;
    public function checkIfWon(array $board): bool;
    public function update(array $board, string $player, int $x, int $y): array;
}
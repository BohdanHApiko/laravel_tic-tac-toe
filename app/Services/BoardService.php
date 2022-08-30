<?php

namespace App\Services;

use App\Models\Board;
use SebastianBergmann\Type\FalseType;
use App\Interfaces\BoardServiceInterface;
use App\Exceptions\InvalidMovePlaceTakenException;

class BoardService implements BoardServiceInterface
{
    protected $defaultBoardState = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];

    /**
     * Returns board initial state
     *
     * @return array
     */
    public function getInitState(): array
    {
        return $this->defaultBoardState;
    }

    /**
     * Check if board has a winning condition
     *
     * @param array $board
     * @return boolean
     */
    public function checkIfWon(array $board): bool
    {
        // Check rows
        for ($row = 0; $row < 3; $row++) {
            if ($board[$row][0] && ($board[$row][0] === $board[$row][1]) && ($board[$row][1] === $board[$row][2])) {
                return true;
            }
        }

        // Check columns
        for ($col = 0; $col < 3; $col++) {
            if ($board[0][$col] && ($board[0][$col] === $board[1][$col]) && ($board[1][$col] === $board[2][$col])) {
                return true;
            }
        }

        // Check 2 diagonals
        if ($board[0][0] && ($board[0][0] === $board[1][1]) && ($board[1][1] === $board[2][2])) {
            return true;
        }

        if ($board[0][2] && ($board[0][2] === $board[1][1]) && ($board[1][1] === $board[2][0])) {
            return true;
        }

        return false;
    }

    /**
     * Updates board state
     *
     * @param array $board
     * @param string $player
     * @param integer $x
     * @param integer $y
     * @throws InvalidMovePlaceTakenException
     * @return array
     */
    public function update(array $board, string $player, int $x, int $y): array
    {
        if (!empty($board[$x][$y])) {
            throw new InvalidMovePlaceTakenException();
        }

        $board[$x][$y] = $player;

        return $board;
    }
}
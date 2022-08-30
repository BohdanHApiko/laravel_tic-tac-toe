<?php

namespace App\Services;

use App\Models\Game;
use App\Interfaces\GameServiceInterface;
use App\Interfaces\BoardServiceInterface;

class GameService implements GameServiceInterface
{
    /**
     * Board service
     *
     * @var BoardServiceInterface
     */
    protected $boardService;

    /**
     * Possible player letters
     *
     * @var array
     */
    protected $playersLetters = ['x', 'o'];

    public function __construct(BoardServiceInterface $boardService)
    {
        $this->boardService = $boardService;
    }

    /**
     * Returns game state
     *
     * @return Game
     */
    public function start(): Game
    {
        $game = $this->getExistingGame();

        if (!$game) {
            $game = $this->createNewgame();
        }

        return $game;
    }

    public function restart(): Game
    {
        $game = $this->getExistingGame();

        if (!$game) {
            return $this->createNewgame();
        }

        if ($game->winner) {
            $this->updateScore($game);
        }

        $game->fill([
            'board_state' => $this->boardService->getInitState(),
            'current_turn' => $this->getRandomPlayerLetter(),
            'winner' => '',
        ]);

        $game->save();

        return $game;
    }

    /**
     * Resets a game
     *
     * @return Game
     */
    public function reset(): Game
    {
        $this->deleteGame();

        return $this->createNewgame();
    }

    /**
     * Undocumented function
     *
     * @return Game|null
     */
    public function getExistingGame(): ?Game
    {
        $game = Game::first();

        if ($game) {
            return $game;
        }

        return null;
    }

    /**
     * Creates fresh game state
     *
     * @return Game
     */
    public function createNewgame(): Game
    {
        return Game::create([
            'board_state' => $this->boardService->getInitState(),
            'current_turn' => $this->getRandomPlayerLetter(),
            'winner' => '',
        ]);
    }

    /**
     * Deletes a game
     *
     * @return boolean
     */
    public function deleteGame(): bool
    {
        $game = Game::first();

        if ($game) {
            return $game->delete();
        }

        return true;
    }

    /**
     * Updates score if there is a winner
     *
     * @param Game $game
     * @return Game
     */
    public function updateScore(Game $game): Game
    {
        if ($game->winner) {
            $game->increment("score_{$game->winner}");
        }

        return $game;
    }

    public function getAvailablePlayerLetters()
    {
        return $this->playersLetters;
    }

    /**
     * Return random available player letter
     *
     * @return void
     */
    public function getRandomPlayerLetter(): string
    {
        return $this->getAvailablePlayerLetters()[array_rand($this->getAvailablePlayerLetters)];
    }
}
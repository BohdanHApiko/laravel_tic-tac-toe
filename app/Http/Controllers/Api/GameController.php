<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlacePieceRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\GameCollection;
use App\Interfaces\GameServiceInterface;

class GameController extends Controller
{
    protected $gameService;

    /**
     * @param GameServiceInterface $gameService
     */
    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * Returns current game state
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $game = $this->gameService->start();

        return response()->json(new GameResource($game));
    }

    /**
     * Handles piece placement
     *
     * @param PlacePieceRequest $request
     * @return JsonResponse
     */
    public function placePiece(PlacePieceRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $game = $this->gameService->makeMove($validatedData['piece'], $validatedData['x'], $validatedData['y']);        
    
        return response()->json(new GameResource($game));
    }

    /**
     * Restarts a game
     *
     * @return JsonResponse
     */
    public function restart(): JsonResponse
    {
        $game = $this->gameService->restart();

        return response()->json(new GameResource($game));
    }

    /**
     * Deletes current game state
     *
     * @return JsonResponse
     */
    public function delete(): JsonResponse
    {
        $game = $this->gameService->reset();

        return response()->json(['currentTurn' => $game->current_turn]);
    }
}

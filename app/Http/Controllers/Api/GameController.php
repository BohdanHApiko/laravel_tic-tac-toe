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

    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }

    public function get(): JsonResponse
    {
        $game = $this->gameService->start();

        return response()->json(new GameResource($game));
    }

    public function placePiece(PlacePieceRequest $request)
    {
        $validatedData = $request->validated();

        $game = $this->gameService->makeMove($validatedData['piece'], $validatedData['x'], $validatedData['y']);        
    
        return response()->json(new GameResource($game));
    }

    public function restart()
    {
        $game = $this->gameService->restart();

        return response()->json(new GameResource($game));
    }

    public function delete()
    {
        $game = $this->gameService->reset();

        return response()->json(['currentTurn' => $game->current_turn]);
    }
}

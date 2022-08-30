<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'board' => $this->board_state,
            'score' => [
                'x' => $this->score_x,
                'o' => $this->score_o
            ],
            'currentTurn' => $this->current_turn,
            'victory' => $this->winner
        ];
    }
}

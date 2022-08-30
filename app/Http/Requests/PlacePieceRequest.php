<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Interfaces\GameServiceInterface;
use Illuminate\Foundation\Http\FormRequest;

class PlacePieceRequest extends FormRequest
{
    protected $gameService;

    public function __construct(GameServiceInterface $gameService)
    {
        parent::__construct();

        $this->gameService = $gameService;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'piece' => ['required', Rule::in($this->gameService->getAvailablePlayerLetters())],
            'x' => 'required|integer|gte:0',
            'y' => 'required|integer|gte:0'
        ];
    }

    public function validationData(): array
    { 
        return $this->route()->parameters() + $this->all();
    }
}

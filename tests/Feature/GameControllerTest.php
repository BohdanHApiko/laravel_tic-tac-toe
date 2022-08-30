<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Models\Game;
use Mockery\MockInterface;
use App\Services\GameService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetGameRequestEndpointIsAccessible()
    {
        $response = $this->get('/api/');

        $response->assertStatus(200);
    }

    public function testMakeSureJsonResponseHasCorrectStructure()
    {
        $response = $this->get('/api/');

        $response->assertJson(fn (AssertableJson $json) => (
            $json
                ->hasAll(['board', 'score', 'currentTurn', 'victory'])
                ->whereAllType([
                    'board' => 'array',
                    'score' => 'array',
                    'currentTurn' => 'string',
                    'victory' => 'string'
                ])
        ));
    }

    public function testPlacePieceSuccess()
    {
        $game = Game::factory()->create();

        $response = $this->postJson('/api/x', ['x' => 2, 'y' => 2]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'board' => [],
                'score' => [],
                'currentTurn',
                'victory'
            ]);
        
    }

    public function testPlacePieceSuccessWinCondition()
    {
        $game = Game::factory()->create([
            'board_state' => [
                ['x', '', ''],
                ['', 'x', ''],
                ['', '', '']
            ],
        ]);

        $response = $this->postJson('/api/x', ['x' => 2, 'y' => 2]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'board' => [],
                'score' => [],
                'currentTurn',
                'victory'
            ])
            ->assertJsonPath('victory', 'x');
        
    }

    public function testPlacePiecePlaceAlreadyTakenError()
    {
        $game = Game::factory()->create([
            'board_state' => [
                ['x', '', ''],
                ['', '', ''],
                ['', '', '']
            ],
        ]);

        $response = $this->postJson('/api/x', ['x' => 0, 'y' => 0]);
        $response
            ->assertStatus(409);
    }

    public function testPlacePieceWrongTurnError()
    {
        $game = Game::factory()->create([
            'board_state' => [
                ['x', '', ''],
                ['', '', ''],
                ['', '', '']
            ],
        ]);

        $response = $this->postJson('/api/o', ['x' => 0, 'y' => 0]);
        $response
            ->assertStatus(406);
    }

    public function testResetBoardAndScoreCalculation()
    {
        $game = Game::factory()->create([
            'board_state' => [
                ['x', '', ''],
                ['', 'x', ''],
                ['', '', 'x']
            ],
            'winner' => 'x'
        ]);

        $response = $this->postJson('/api/restart');
        $response
            ->assertStatus(200)
            ->assertJsonPath('score.x', 1);
    }
}

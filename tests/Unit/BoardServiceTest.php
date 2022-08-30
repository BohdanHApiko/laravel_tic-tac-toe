<?php

namespace Tests\Unit;

use App\Services\BoardService;
use PHPUnit\Framework\TestCase;
use App\Exceptions\InvalidMovePlaceTakenException;

class BoardServiceTest extends TestCase
{
    /**
     * Test if BoardService can detect won conditions
     *
     * @dataProvider wonConditionsProvider
     */
    public function testWinningCondition($board)
    {
        $boardService = resolve(BoardService::class);
        $this->assertTrue($boardService->checkIfWon($board));
    }

    /**
     * Test if BoardService can detect not won conditions
     *
     * @dataProvider notwonConditionsProvider
     */
    public function testNotWonCondition($board)
    {
        $boardService = resolve(BoardService::class);
        $this->assertFalse($boardService->checkIfWon($board));
    }

    /**
     * @dataProvider successfulBoardUpdateTestProvider
     */
    public function testIfBoardCanBeUpdated($board, $player, $x, $y, $expected) {
        $boardService = resolve(BoardService::class);

        $this->assertEquals($boardService->update($board, $player, $x, $y), $expected);
    }

    /**
     * @dataProvider failedBoardUpdateTestProvider
     */
    public function testIfThrowsExceptionWhenUpdatedWithIncorrectData($board, $player, $x, $y) {
        $boardService = resolve(BoardService::class);

        $this->expectException(InvalidMovePlaceTakenException::class);
        $boardService->update($board, $player, $x, $y);
    }

    /**
     * Possible won boards
     *
     * @return array
     */
    public function wonConditionsProvider()
    {
        return [
            [
                [['x', 'o', 'o'], ['x', '', ''], ['x', 'o', '']]
            ], 
            [
                [['x', 'o', 'o'], ['o', 'x', ''], ['', 'o', 'x']]
            ], 
            [
                [['', '', 'x'], ['', 'x', ''], ['x', '', '']]
            ],
            [
                [['x', 'x', 'x'], ['', '', ''], ['', '', '']]
            ],
        ];
    }

    public function notwonConditionsProvider()
    {
        return [
            [
                [['', 'o', 'o'], ['x', '', ''], ['x', 'o', '']]
            ], 
            [
                [['x', 'o', 'o'], ['o', 'x', ''], ['', 'o', 'o']]
            ], 
            [
                [['', '', 'x'], ['', 'o', ''], ['x', '', '']]
            ],
            [
                [['x', 'x', 'o'], ['', '', ''], ['', '', '']]
            ],
        ];
    }

    public function successfulBoardUpdateTestProvider()
    {
        return [
            [
                [['', 'o', 'o'], ['x', '', ''], ['x', 'o', '']],
                'x',
                0,
                0,
                [['x', 'o', 'o'], ['x', '', ''], ['x', 'o', '']],
            ]
        ];
    }

    public function failedBoardUpdateTestProvider()
    {
        return [
            [
                [['', 'o', 'o'], ['x', '', ''], ['x', 'o', '']],
                'x',
                1,
                0
            ]
        ];
    }
}

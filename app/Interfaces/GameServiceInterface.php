<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface GameServiceInterface
{
    function start(): Model;
    function reset(): Model;
    function restart(): Model;
    function createNewgame(): Model;
    function getRandomPlayerLetter(): string;
}
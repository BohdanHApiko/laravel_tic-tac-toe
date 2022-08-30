<?php

namespace App\Providers;

use App\Interfaces\BoardServiceInterface;
use App\Interfaces\GameServiceInterface;
use App\Services\BoardService;
use App\Services\GameService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(GameServiceInterface::class, GameService::class);
        $this->app->bind(BoardServiceInterface::class, BoardService::class);
    }
}

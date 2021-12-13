<?php

namespace App\Providers;

use App\Http\Controllers\Api\BooksApiController;
use App\Http\Controllers\BooksController;
use App\Models\Book;
use App\Repositories\BooksRepository;
use App\Services\BooksService;
use Illuminate\Container\Container;
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
        $this->registerBooksController();
        $this->registerBooksApiController();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function registerBooksController()
    {
        $this->app->singleton(
            BooksController::class,
            function (Container $app) {
                return new BooksController(
                    $app->make(Book::class),
                    $app->make(BooksService::class),
                    $app->make(BooksRepository::class),
                );
            }
        );
    }

    protected function registerBooksApiController()
    {
        $this->app->singleton(
            BooksApiController::class,
            function (Container $app) {
                return new BooksApiController(
                    $app->make(Book::class),
                    $app->make(BooksRepository::class),
                );
            }
        );
    }
}

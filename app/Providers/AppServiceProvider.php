<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\KTBootstrap;
use App\Models\RcvHead;
use App\Repositories\OrdHead\OrdHeadRepository;
use App\Repositories\RcvDetail\RcvDetailRepository;
use App\Repositories\RcvHead\RcvHeadRepository;
use App\Repositories\RcvHead\RcvHeadRepositoryImplement;
use App\Services\Rcv\RcvService;
use App\Services\Rcv\RcvServiceImplement;
use Illuminate\Database\Schema\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // Binding the repositories
        $this->app->bind(OrdHeadRepository::class, function ($app) {
            return new OrdHeadRepository(); // Adjust as necessary
        });

        $this->app->bind(RcvDetailRepository::class, function ($app) {
            return new RcvDetailRepository(); // Adjust as necessary
        });

        $this->app->bind(RcvHeadRepository::class, function ($app) {
            return new RcvHeadRepository(); // Adjust as necessary
        });

        // Binding the RcvService interface to its implementation
        $this->app->singleton(RcvService::class, function ($app) {
            return new RcvServiceImplement(
                $app->make(OrdHeadRepository::class),
                $app->make(RcvDetailRepository::class),
                $app->make(RcvHeadRepository::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Builder::defaultStringLength(191);
        KTBootstrap::init();
    }
}

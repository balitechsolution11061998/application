<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\KTBootstrap;
use App\Models\RcvHead;
use App\Repositories\RcvHead\RcvHeadRepositoryImplement;
use App\Services\Rcv\RcvService;
use Illuminate\Database\Schema\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
         // Binding RcvHeadRepositoryImplement
         $this->app->bind(RcvHeadRepositoryImplement::class, function ($app) {
            return new RcvHeadRepositoryImplement(new RcvHead());
        });

        // Binding RcvService
        $this->app->singleton(RcvService::class, function ($app) {
            return new RcvService($app->make(RcvHeadRepositoryImplement::class));
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

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\KTBootstrap;
use App\Models\OrdHead;
use App\Repositories\Order\OrderRepositoryImplement;
use App\Services\Order\OrderService;
use App\Services\Order\OrderServiceImplement;
use Illuminate\Database\Schema\Builder;
use App\Jobs\ExampleJob;
use App\Models\Permission;
use App\Repositories\Permissions\PermissionsRepositoryImplement;
use App\Services\Permissions\PermissionsService;
use App\Services\Permissions\PermissionsServiceImplement;
use Illuminate\Support\Facades\Auth;
use Inspector\Laravel\Facades\Inspector;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->extend(OrderService::class, function ($service, $app) {
            $orderRepository = new OrderRepositoryImplement(new OrdHead());
            return new OrderServiceImplement($orderRepository);
        });

        $this->app->extend(PermissionsService::class, function ($service, $app) {
            $permissionsRepository = new PermissionsRepositoryImplement(new Permission());
            return new PermissionsServiceImplement($permissionsRepository);
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

        Inspector::beforeFlush(function ($inspector) {
            if ($inspector->transaction()->name === ExampleJob::class) {
                $prob = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();

                return $prob < 0.7; // Report 70% of the executions
            }
        });
    }
}

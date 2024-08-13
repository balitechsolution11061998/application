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
use App\Jobs\LogQueryPerformance;
use App\Models\PerformanceAnalysis;
use App\Models\Permission;
use App\Models\QueryLog;
use App\Models\QueryPerformanceLog;
use App\Models\User;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Permissions\PermissionsRepositoryImplement;
use App\Services\PerformanceLogger\PerformanceLoggerService;
use App\Services\Permissions\PermissionsService;
use App\Services\Permissions\PermissionsServiceImplement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inspector\Laravel\Facades\Inspector;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(OrderServiceImplement::class, function ($app) {
            return new OrderServiceImplement(
                $app->make(OrderRepository::class),
                $app->make(PerformanceLoggerService::class)
            );
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

        Gate::define('viewPulse', function (User $user) {
            return $user->hasRole('superadministrator');
        });

    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\KTBootstrap;
use App\Models\OrdHead;
use App\Models\RcvDetail;
use App\Models\RcvHead;
use App\Models\User;
use App\Repositories\OrdHead\OrdHeadRepository;
use App\Repositories\RcvDetail\RcvDetailRepository;
use App\Repositories\RcvDetail\RcvDetailRepositoryImplement;
use App\Repositories\RcvHead\RcvHeadRepository;
use App\Repositories\RcvHead\RcvHeadRepositoryImplement;
use App\Services\Rcv\RcvService;
use App\Services\Rcv\RcvServiceImplement;
use Illuminate\Database\Schema\Builder;
use App\Repositories\OrdHead\OrdHeadRepositoryImplement;
use App\Repositories\OrdSku\OrdSkuRepository;
use App\Repositories\OrdSku\OrdSkuRepositoryImplement;
use App\Services\Order\OrderService;
use App\Services\Order\OrderServiceImplement;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // Binding OrdHeadRepository to its implementation
        $this->app->bind(OrdHeadRepository::class, function ($app) {
            return new OrdHeadRepositoryImplement($app->make(OrdHead::class)); // Adjust constructor parameters as necessary
        });

        // Binding RcvDetailRepository to its implementation
        $this->app->bind(RcvDetailRepository::class, function ($app) {
            return new RcvDetailRepositoryImplement($app->make(RcvDetail::class)); // Adjust constructor parameters as necessary
        });

        // Binding RcvHeadRepository to its implementation
        $this->app->bind(RcvHeadRepository::class, function ($app) {
            return new RcvHeadRepositoryImplement($app->make(RcvHead::class)); // Adjust constructor parameters as necessary
        });

        // Binding the RcvService interface to its implementation
        $this->app->singleton(RcvService::class, function ($app) {
            return new RcvServiceImplement(
                $app->make(OrdHeadRepository::class),
                $app->make(RcvDetailRepository::class),
                $app->make(RcvHeadRepository::class)
            );
        });
        $this->app->bind(OrdSkuRepository::class, OrdSkuRepositoryImplement::class);

        $this->app->singleton(OrderService::class, function ($app) {
            return new OrderServiceImplement(
                $app->make(OrdHeadRepository::class),
                $app->make(OrdSkuRepository::class)
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

        Gate::define('viewPulse', function (User $user) {
            return $user->hasRole('superadministrator');
        });

        Blade::directive('formatRupiah', function ($amount) {
            return "<?php echo 'Rp' . number_format($amount, 0, ',', '.'); ?>";
        });
          // You can use the Blade facade to create a custom directive
        Blade::directive('formattedDate', function ($expression) {
            return "<?php echo \App\Helpers\DateHelper::formatDate($expression); ?>";
        });
    }
}

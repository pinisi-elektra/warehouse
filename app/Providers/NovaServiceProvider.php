<?php

namespace App\Providers;

use App\Helpers\RoleList;
use App\Models\ProductRequest;
use App\Models\ProductStockActivity;
use App\Models\ProductTransaction;
use App\Models\ProductTransactionVendor;
use App\Models\User;
use App\Models\ProductTransactionShipping;
use App\Observers\ProductRequestObserver;
use App\Observers\ProductStockActivityObserver;
use App\Observers\ProductTransactionObserver;
use App\Observers\ProductTransactionShippingObserver;
use App\Observers\ProductTransactionVendorObserver;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Observable;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Observable::make(ProductTransaction::class, ProductTransactionObserver::class);
        Observable::make(ProductTransactionShipping::class, ProductTransactionShippingObserver::class);
        Observable::make(ProductTransactionVendor::class, ProductTransactionVendorObserver::class);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function (User $user) {
            return $user->isRoleMatch(RoleList::WAREHOUSE_ADMIN) || $user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

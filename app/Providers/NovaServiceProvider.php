<?php

namespace App\Providers;

use App\Helpers\RoleList;
use App\Models\ProductTransaction;
use App\Models\ProductTransactionSales;
use App\Models\ProductTransactionShipping;
use App\Models\ProductTransactionVendor;
use App\Models\User;
use App\Nova\Dashboards\Main;
use App\Nova\Product;
use App\Nova\ProductStock;
use App\Nova\ProductVendor;
use App\Nova\Project;
use App\Nova\Purchase;
use App\Nova\Sales;
use App\Nova\StockTransfer;
use App\Nova\Warehouse;
use App\Observers\ProductTransactionObserver;
use App\Observers\ProductTransactionSalesObserver;
use App\Observers\ProductTransactionShippingObserver;
use App\Observers\ProductTransactionVendorObserver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
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

        Nova::withoutNotificationCenter();

        Observable::make(ProductTransaction::class, ProductTransactionObserver::class);
        Observable::make(ProductTransactionShipping::class, ProductTransactionShippingObserver::class);
        Observable::make(ProductTransactionVendor::class, ProductTransactionVendorObserver::class);
        Observable::make(ProductTransactionSales::class, ProductTransactionSalesObserver::class);

        Nova::mainMenu(function (Request $request) {
            if ($request->user()->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN)) {
                return [
                    MenuSection::dashboard(Main::class)->icon('chart-bar'),

                    MenuSection::make('Main Feature', [
                        MenuItem::resource(Purchase::class),
                        MenuItem::resource(StockTransfer::class),
                        MenuItem::resource(Sales::class),
                    ])->icon('collection'),

                    MenuSection::make('Master Data', [
                        MenuItem::resource(ProductStock::class),
                        MenuItem::resource(Product::class),
                        MenuItem::resource(Warehouse::class),
                        MenuItem::resource(ProductVendor::class),
                        MenuItem::resource(Project::class),
                    ])->icon('database')->collapsable(),
                ];
            }

            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('Main Feature', [
                    MenuItem::resource(StockTransfer::class),
                    MenuItem::resource(Sales::class),
                ])->icon('collection'),

                MenuSection::make('Master Data', [
                    MenuItem::resource(ProductStock::class),
                    MenuItem::resource(Product::class),
                    MenuItem::resource(ProductVendor::class),
                ])->icon('database')->collapsable(),
            ];
        });
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

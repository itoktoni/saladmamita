<?php

namespace Modules\Sales\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Sales\Dao\Repositories\DeliveryRepository;
use Modules\Sales\Dao\Repositories\SubscribeRepository;
use Modules\Sales\Dao\Repositories\DeliveryDetailRepository;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind('order_facades', function () {
            return new \Modules\Sales\Dao\Repositories\OrderRepository();
        });
        $this->app->bind('subscribe_facades', function () {
            return new \Modules\Sales\Dao\Repositories\SubscribeRepository();
        });
        $this->app->bind('order_detail_facades', function () {
            return new \Modules\Sales\Dao\Repositories\OrderDetailRepository();
        });
        $this->app->bind('order_detail_variant_facades', function () {
            return new \Modules\Sales\Dao\Models\OrderDetailVariant();
        });
        $this->app->bind('delivery_facades', function () {
            return new \Modules\Sales\Dao\Repositories\DeliveryRepository();
        });
        $this->app->bind('delivery_detail_facades', function () {
            return new \Modules\Sales\Dao\Repositories\DeliveryDetailRepository();
        });
        $this->app->bind('quotation_facades', function () {
            return new \Modules\Sales\Dao\Repositories\QuotationRepository();
        });
        $this->app->bind('quotation_detail_facades', function () {
            return new \Modules\Sales\Dao\Repositories\QuotationDetailRepository();
        });

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('Sales.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'Sales'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/Sales');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/Sales';
        }, \Config::get('view.paths')), [$sourcePath]), 'Sales');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/Sales');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'Sales');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'Sales');
        }
    }

    /**
     * Register an additional directory of Repositories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

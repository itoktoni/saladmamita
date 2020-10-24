<?php

namespace Modules\Finance\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

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
        $this->app->bind('account_facades', function () {
            return new \Modules\Finance\Dao\Repositories\AccountRepository();
        });
        $this->app->bind('bank_facades', function () {
            return new \Modules\Finance\Dao\Repositories\BankRepository();
        });
        $this->app->bind('flag_facades', function () {
            return new \Modules\Finance\Dao\Repositories\FlagRepository();
        });
        $this->app->bind('payment_facades', function () {
            return new \Modules\Finance\Dao\Repositories\PaymentRepository();
        });
        $this->app->bind('tax_facades', function () {
            return new \Modules\Finance\Dao\Repositories\TaxRepository();
        });
        $this->app->bind('top_facades', function () {
            return new \Modules\Finance\Dao\Repositories\TopRepository();
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
            __DIR__.'/../Config/config.php' => config_path('Finance.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'Finance'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/Finance');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/Finance';
        }, \Config::get('view.paths')), [$sourcePath]), 'Finance');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/Finance');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'Finance');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'Finance');
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

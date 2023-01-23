<?php

declare(strict_types=1);

namespace VienasBaitas\Strapi\Client\Laravel;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use VienasBaitas\Strapi\Client\Client;
use VienasBaitas\Strapi\Client\Laravel\Contracts\Factory;

class StrapiServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/strapi.php', 'strapi');

        $this->registerManager();
    }

    /**
     * Register the strapi instance.
     *
     * @return void
     */
    protected function registerManager(): void
    {
        $this->app->singleton('strapi.manager', function ($app) {
            return new StrapiManager($app);
        });

        $this->app->bind('strapi.client', function ($app) {
            return $app->make('strapi.manager')->client();
        });

        $this->app->bind(Factory::class, 'strapi.manager');
        $this->app->bind(Client::class, 'strapi.client');
    }

    /**
     * Bootstrap package services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/strapi.php' => config_path('strapi.php'),
        ]);
    }

    public function provides(): array
    {
        return [
            'strapi.manager',
            Factory::class,
            'strapi.client',
            Client::class,
        ];
    }
}

<?php

declare(strict_types=1);

namespace MBVienasBaitas\Strapi\Client\Laravel;

class Strapi
{
    /**
     * A callback that can resolve PSR client interface implementation.
     *
     * @var callable|null
     */
    public static $clientResolveCallback = null;

    /**
     * A callback that can resolve PSR request factory interface implementation.
     *
     * @var callable|null
     */
    public static $requestFactoryResolveCallback = null;

    /**
     * Specify a callback that should be used to resolve http client interface implementation.
     *
     * @param callable $callback
     * @return void
     */
    public static function resolveClientUsing(callable $callback): void
    {
        static::$clientResolveCallback = $callback;
    }

    /**
     * Specify a callback that should be used to resolve request factory interface implementation.
     *
     * @param callable $callback
     * @return void
     */
    public static function resolveRequestFactoryUsing(callable $callback): void
    {
        static::$requestFactoryResolveCallback = $callback;
    }
}
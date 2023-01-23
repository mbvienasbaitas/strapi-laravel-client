<?php

declare(strict_types=1);

namespace VienasBaitas\Strapi\Client\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \VienasBaitas\Strapi\Client\Client client(string|null $name = null)
 * @method static \VienasBaitas\Strapi\Client\Endpoints\Collection collection(string $resource)
 * @method static \VienasBaitas\Strapi\Client\Endpoints\Single single(string $resource)
 * @method static \VienasBaitas\Strapi\Client\Endpoints\Media media()
 *
 * @see \VienasBaitas\Strapi\Client\Client
 */
class Strapi extends Facade
{
    /**
     * Get the registered name for client.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'strapi.manager';
    }
}

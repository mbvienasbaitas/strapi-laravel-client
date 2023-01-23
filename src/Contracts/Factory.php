<?php

declare(strict_types=1);

namespace MBVienasBaitas\Strapi\Client\Laravel\Contracts;

use MBVienasBaitas\Strapi\Client\Client;

interface Factory
{
    /**
     * Get client instance by name.
     *
     * @param string|null $name
     * @return Client
     */
    public function client(string|null $name = null): Client;
}

<?php

declare(strict_types=1);

namespace VienasBaitas\Strapi\Client\Laravel\Contracts;

use VienasBaitas\Strapi\Client\Client;

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

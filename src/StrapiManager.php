<?php

declare(strict_types=1);

namespace VienasBaitas\Strapi\Client\Laravel;

use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use VienasBaitas\Strapi\Client\Client;

class StrapiManager implements Contracts\Factory
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected Application $app;

    /**
     * The array of resolved clients.
     *
     * @var array<string, Client>
     */
    protected array $clients = [];

    /**
     * Create new Strapi manager instance.
     *
     * @param Application $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get client instance by name.
     *
     * @param string|null $name
     * @return Client
     */
    public function client(string|null $name = null): Client
    {
        $name = $name ?: $this->getDefaultClient();

        return $this->clients[$name] = $this->get($name);
    }

    /**
     * Attempt to get the client from the local cache.
     *
     * @param string $name
     * @return Client
     */
    protected function get(string $name): Client
    {
        return $this->clients[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given client.
     *
     * @param string $name
     * @return Client
     */
    protected function resolve(string $name): Client
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("Strapi Client [{$name}] is not defined.");
        }

        return $this->createClient($config);
    }

    /**
     * Create new client instance.
     *
     * @param array $config
     * @return Client
     */
    public function createClient(array $config): Client
    {
        return new Client(
            (string)$config['endpoint'],
            (string)$config['token'],
            $this->createClientInterface($config),
            $this->createRequestFactoryInterface($config),
        );
    }

    protected function createClientInterface(array $config): ClientInterface|null
    {
        return Strapi::$clientResolveCallback ? call_user_func(
            Strapi::$clientResolveCallback,
            $config
        ) : null;
    }

    protected function createRequestFactoryInterface(array $config): RequestFactoryInterface|null
    {
        return Strapi::$requestFactoryResolveCallback ? call_user_func(
            Strapi::$requestFactoryResolveCallback,
            $config
        ) : null;
    }

    /**
     * Get the client configuration.
     *
     * @param string $name
     * @return array|null
     */
    protected function getConfig(string $name): array|null
    {
        return $this->app['config']["strapi.clients.{$name}"];
    }

    /**
     * Get the default strapi client name.
     *
     * @return string
     */
    public function getDefaultClient(): string
    {
        return $this->app['config']['strapi.default'];
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->client()->$method(...$parameters);
    }
}

<?php

declare(strict_types=1);

namespace Tests;

use InvalidArgumentException;
use Orchestra\Testbench\TestCase;
use VienasBaitas\Strapi\Client\Client;
use VienasBaitas\Strapi\Client\Laravel\Contracts\Factory;
use VienasBaitas\Strapi\Client\Laravel\Facades\Strapi;
use VienasBaitas\Strapi\Client\Laravel\StrapiServiceProvider;

class StrapiManagerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        \VienasBaitas\Strapi\Client\Laravel\Strapi::$clientResolveCallback = null;
        \VienasBaitas\Strapi\Client\Laravel\Strapi::$requestFactoryResolveCallback = null;
    }

    protected function getPackageProviders($app)
    {
        return [
            StrapiServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('strapi.default', 'default');
        $app['config']->set('strapi.clients', [
            'default' => [
                'endpoint' => 'https://localhost:1337',
                'token' => 'token',
            ],
            'custom' => [
                'endpoint' => 'https://localhost:1337',
                'token' => 'token',
            ],
        ]);
    }

    public function testCreateDefaultClient(): void
    {
        $client = $this->app['strapi.manager']->client();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(Client::class, Strapi::client());
    }

    public function testCreateCustomClient(): void
    {
        $client = $this->app['strapi.manager']->client('custom');

        $this->assertInstanceOf(Client::class, $client);
    }

    public function testCreateClientThrowsException(): void
    {
        try {
            $this->app['strapi.manager']->client('non_existent');
            $this->fail('InvalidArgumentException not raised.');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals('Strapi Client [non_existent] is not defined.', $e->getMessage());
        }
    }

    public function testResolvesDefaultBoundClient(): void
    {
        $this->assertInstanceOf(Client::class, $this->app['strapi.client']);
        $this->assertInstanceOf(Client::class, $this->app[Client::class]);
    }

    public function testResolvesFactory(): void
    {
        $this->assertInstanceOf(Factory::class, $this->app['strapi.manager']);
        $this->assertInstanceOf(Factory::class, $this->app[Factory::class]);
    }

    public function testCustomClientResolverIsUsed(): void
    {
        \VienasBaitas\Strapi\Client\Laravel\Strapi::resolveClientUsing(function () {
            throw new \Exception('Client resolver: I am failing...');
        });

        try {
            $this->app['strapi.manager']->client();
            $this->fail('Custom client resolver not called.');
        } catch (\Exception $e) {
            $this->assertEquals('Client resolver: I am failing...', $e->getMessage());
        }
    }

    public function testCustomRequestFactoryResolverIsUsed(): void
    {
        \VienasBaitas\Strapi\Client\Laravel\Strapi::resolveRequestFactoryUsing(function () {
            throw new \Exception('Request factory resolver: I am failing...');
        });

        try {
            $this->app['strapi.manager']->client();
            $this->fail('Custom request factory resolver not called.');
        } catch (\Exception $e) {
            $this->assertEquals('Request factory resolver: I am failing...', $e->getMessage());
        }
    }
}

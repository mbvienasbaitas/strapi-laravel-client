# Strapi Laravel Client library

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mbvienasbaitas/strapi-laravel-client.svg?style=flat-square)](https://packagist.org/packages/mbvienasbaitas/strapi-laravel-client)
![Test Status](https://img.shields.io/github/actions/workflow/status/mbvienasbaitas/strapi-laravel-client/run-tests.yaml?label=tests&branch=main)
[![Total Downloads](https://img.shields.io/packagist/dt/mbvienasbaitas/strapi-laravel-client.svg?style=flat-square)](https://packagist.org/packages/mbvienasbaitas/strapi-laravel-client)

Laravel package to enable easier Strapi client management provided by [mbvienasbaitas/strapi-php-client](https://github.com/mbvienasbaitas/strapi-php-client) package.

## Installation

To get started, simply require the project using [Composer](https://getcomposer.org/).<br>
You will also need to install packages that "provide" [`psr/http-client-implementation`](https://packagist.org/providers/psr/http-client-implementation) and [`psr/http-factory-implementation`](https://packagist.org/providers/psr/http-factory-implementation). which is required by [mbvienasbaitas/strapi-php-client](https://github.com/mbvienasbaitas/strapi-php-client)<br>

```bash
composer require mbvienasbaitas/strapi-laravel-client
```

## Usage

### Default client configuration

Default client can be configured via environment. Here is a list of available configuration options.

| Environment variable | Description                                                    |
|----------------------|----------------------------------------------------------------|
| STRAPI_CLIENT        | Default client configuration to be used. Defaults to `default` |
| STRAPI_ENDPOINT      | Endpoint url, eg.: `https://localhost:1337`                    |
| STRAPI_TOKEN         | Bearer token used for authentication.                          |

### Default client using facade

```php
use VienasBaitas\Strapi\Client\Contracts\Requests\Collection\IndexRequest;
use VienasBaitas\Strapi\Client\Laravel\Facades\Strapi;

$collection = Strapi::collection('pages');

$response = $collection->index(IndexRequest::make());
```

### Default client using injection

```php
use VienasBaitas\Strapi\Client\Client;
use VienasBaitas\Strapi\Client\Contracts\Requests\Collection\IndexRequest;

class BlogController
{
    public function index(Client $client)
    {
        $collection = $client->collection('pages');

        return $collection->index(IndexRequest::make());
    }
}
```

### Custom client using facade

```php
use VienasBaitas\Strapi\Client\Contracts\Requests\Collection\IndexRequest;
use VienasBaitas\Strapi\Client\Laravel\Facades\Strapi;

$client = Strapi::client('custom');

$collection = $client->collection('pages');

$response = $collection->index(IndexRequest::make());
```

### Custom client using injection

```php
use VienasBaitas\Strapi\Client\Contracts\Requests\Collection\IndexRequest;
use VienasBaitas\Strapi\Client\Laravel\Contracts\Factory;

class BlogController
{
    public function index(Factory $factory)
    {
        $collection = $factory->client('custom')->collection('pages');

        return $collection->index(IndexRequest::make());
    }
}
```

### Using custom client and request factory interfaces

Custom client and request factory resolved implementations could be bound using built in resolver functionality.
Place snippets shown below in your `ApplicationServiceProvider`.

```php
use VienasBaitas\Strapi\Client\Laravel\Strapi;

Strapi::resolveRequestFactoryUsing(function () {
    // return \Psr\Http\Client\ClientInterface implementation
});

Strapi::resolveRequestFactoryUsing(function () {
    // return \Psr\Http\Message\RequestFactoryInterface implementation
});
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Edvinas Kručas](https://github.com/edvinaskrucas)
- [All Contributors](../../contributors)

## Alternatives

- [dbfx/laravel-strapi](https://github.com/dbfx/laravel-strapi)
- [svnwa/laravel-strapi](https://github.com/svnwa/laravel-strapi)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

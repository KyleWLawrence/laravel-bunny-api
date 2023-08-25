# Laravel Bunny

This package provides integration with the Bunny API. It currently only supports sending a chat message.

## Installation

You can install this package via Composer using:

```bash
composer require kylewlawrence/laravel-bunny-api
```

The facade is automatically installed.

```php
Bunny::get('zones', ['per_page' => 100]);
```

## Configuration

To publish the config file to `app/config/bunny-laravel.php` run:

```bash
php artisan vendor:publish --provider="KyleWLawrence\Bunny\Providers\BunnyServiceProvider"
```

Set your configuration using **environment variables**, either in your `.env` file or on your server's control panel:

- `BUNNY_ACCESS_KEY`

The API access AccessKey. You can create one as described here: `https://dash.bunny.net/account/settings`

- `BUNNY_DRIVER` _(Optional)_

Set this to `null` or `log` to prevent calling the Bunny API directly from your environment.

## Contributing

Pull Requests are always welcome here. I'll catch-up and develop the contribution guidelines soon. For the meantime, just open and issue or create a pull request.

## Usage

### Facade

The `Bunny` facade acts as a wrapper for an instance of the `Bunny\Http\HttpClient` class.

### Dependency injection

If you'd prefer not to use the facade, you can instead inject `KyleWLawrence\Bunny\Services\BunnyService` into your class. You can then use all of the same methods on this object as you would on the facade.

```php
<?php

use KyleWLawrence\Bunny\Services\BunnyService;

class MyClass {

    public function __construct(BunnyService $bunny_service) {
        $this->bunny_service = $bunny_service;
    }

}
```

This package is available under the [MIT license](http://opensource.org/licenses/MIT).

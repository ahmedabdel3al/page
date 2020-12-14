# 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/code95/pages.svg?style=flat-square)](https://packagist.org/packages/code95/pages)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/code95/pages/run-tests?label=tests)](https://github.com/code95/pages/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/code95/pages.svg?style=flat-square)](https://packagist.org/packages/code95/pages)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.


## Installation

You can install the package via composer:

```bash
composer require code95/pages
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Code95\Page\PageServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Code95\Page\PageServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

``` php
$pages = new Code95\Page();
echo $pages->echoPhrase('Hello, Code95!');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ahmed Abdelaal](https://github.com/ahmedabdel3al)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

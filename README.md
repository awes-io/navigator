# Navigator


TODO: github or gitlab badge 

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

[![Coverage report](http://gitlab.awescode.com/awes-io/navigator/badges/master/coverage.svg)](https://www.awes.io/)
[![Build status](http://gitlab.awescode.com/awes-io/navigator/badges/master/build.svg)](https://www.awes.io/)
[![Composer Ready](https://www.awc.wtf/awes-io/navigator/status.svg)](https://www.awes.io/)
[![Downloads](https://www.awc.wtf/awes-io/navigator/downloads.svg)](https://www.awes.io/)
[![Last version](https://www.awc.wtf/awes-io/navigator/version.svg)](https://www.awes.io/) 


This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require awes-io/navigator
```

The package will automatically register itself.

You can publish the migration with:

```bash
php artisan vendor:publish --provider="AwesIO\Navigator\Providers\NavigatorServiceProvider" --tag="migrations"
```

After the migration has been published you can create the table for Navigator by running the migrations:

```bash
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="AwesIO\Navigator\Providers\NavigatorServiceProvider" --tag="config"
```


## Examples of use

```php
use AwesIO\Navigator\Facades\Navigator;

Navigator::lowerStr('Some String'); // 'some string'

Navigator::count(); // 1
```

## Methods

#### example()

Description some example.

#### count()

Description some count.

#### validate(string $email)

Throws an `InvalidArgumentException` is email is invalid.

## Testing

You can run the tests with:

```bash
composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [:author_name][link-author]
- [All Contributors][link-contributors]

## License

GNU General Public License v3.0. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/awes-io/navigator.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/awes-io/navigator.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/awes-io/navigator/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/awes-io/navigator
[link-downloads]: https://packagist.org/packages/awes-io/navigator
[link-travis]: https://travis-ci.org/awes-io/navigator
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/awes-io
[link-contributors]: ../../contributors]

# Navigator

[![Coverage report](http://gitlab.awescode.com/awes-io/navigator/badges/master/coverage.svg)](https://www.awes.io/)
[![Build status](http://gitlab.awescode.com/awes-io/navigator/badges/master/build.svg)](https://www.awes.io/)

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require awes-io/navigator
```

The package will automatically register itself.

You can publish the config file with:

```bash
php artisan vendor:publish --provider="AwesIO\Navigator\Providers\NavigatorServiceProvider" --tag="config"
```


## Usage

```php
use AwesIO\Navigator\Facades\Navigator;

$menu = Navigator::buildMenu(config('navigation.menu'), function ($item) {
    $item->put('meta', $item->get('title') . ' / ' . $item->get('link'));
});
```

## Rendering

```php
$menu = Navigator::buildMenu(config('navigation.menu'));
return view('view', compact('menu'));

// view.blade.php
@extends('main')

@section('content')
    @include('menu', ['menu' => $menu])
@endsection

// menu.blade.php
@foreach($menu as $item)
  <ul>
    <li>
        @if($item->link())
            <a href="{{$item->link()}}">{{$item->title}}</a>
        @else
            {{$item->title}}
        @endif
    </li>
    @if($item->hasChildren())
       @include('menu', ['menu' => $item->children()])
    @endif
  </ul>
@endforeach
```

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

- [Alexander Osokin](https://thealex.ru)
- [Galymzhan Begimov](https://github.com/begimov)
- [All Contributors][link-contributors]

## License

[MIT](http://opensource.org/licenses/MIT)

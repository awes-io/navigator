# Navigator

[![Coverage report](http://gitlab.awescode.com/awes-io/navigator/badges/master/coverage.svg)](https://www.awes.io/)
[![Build status](http://gitlab.awescode.com/awes-io/navigator/badges/master/build.svg)](https://www.awes.io/)

Laravel package which can easily create a navigation menu of any complexity, with support for user permissions when displayed. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require awes-io/navigator
```

The package will automatically register itself.

## Usage

```php
use AwesIO\Navigator\Facades\Navigator;

$menu = Navigator::buildMenu(config('navigation.menu'), [], function ($item) {
    $item->put('meta', $item->get('title') . ' / ' . $item->get('link'));
});
```

First parameter is menu configuration in form of array:

```php
// navigation.php
return [
    'menu' => [
        [
            'title' => 'Products', // menu item's title
            'route' => 'products.index', // route name for url generation
            'order' => 1, // parameter to determine the order
            'depth' => 1, // depth for recursive generation of descendants
            'children' => 
            [
                [
                    'id' => 1, // custom id, overwrites auto-generated one
                    'title' => 'Catalog',
                    'link' => 'products/catalog', // explicit relative path for link url 
                ],
                [
                    'title' => 'Support',
                    'route' => 'products.support'
                ]
            ]
        ],
        [
            'title' => 'Contact us',
            'route' => 'contacts',
            'order' => 2,
        ],
    ]
];
```

Second one is mappings for configuration parameters (described below), third is a callback, which will be applied to each menu item.

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --provider="AwesIO\Navigator\NavigatorServiceProvider" --tag="config"
```

You can rename any menu options keys:

```php
// navigator.php config
'keys' => [
    'depth' => 'depth', // depth of children quering
    'order' => 'order', // ordering by parameter
    'children' => 'children', // sub menu items
    'route' => 'route', // route name
    'link' => 'link', // item link url
    'title' => 'title', // item title
    'attr' => 'attr', // additional item attributes
],
```

And use alternative menu settings for parsing and rendering:

```php
// navigator.php config
'keys' => [
    ...
    'children' => 'other-children', // sub menu items
    ...
],

// navigation.php
'menu' => [
    [
        ...
        'children' => [
        ...
        'other-children' => [
        ...
]

Navigator::buildMenu(config('navigation.menu')); // will now parse menu using 'other-children'
```

You achieve same effect dynamically, via mappings mentioned above:

```php
$menu = buildMenu(config('navigation.menu'), ['children' => 'other-children']);
```

Note that you can also use global helper method `buildMenu()`.

### Some helpful methods are available

Determine if node has any children and retrieve them:

```php
$menu->hasChildren();
$menu->children();
```

Get a link url for a node:

```php
$menu->link();
```

Determine if a node is currently selected and active:

```php
$menu->isActive();
```

Get a currently active node and its id:

```php
$menu->getActive();
$menu->getActiveId();
```

Find a node by its id:

```php
$menu->findById($id);
```

## Rendering example

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

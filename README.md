<p align="center">
    <a href="https://www.awes.io/?utm_source=github&utm_medium=repository" target="_blank" rel="noopener noreferrer">
        <img width="100" src="https://static.awes.io/promo/Logo_sign_color.svg" alt="Awes.io logo">
    </a>
</p>

<h1 align="center">Navigator</h1>

<p align="center">Laravel package that can easily create navigation menus of any complexity. With support for routing, permissions, sorting, rendering depth, active items marking and element searching.</p>

<p align="center">
    <a href="https://www.awes.io/?utm_source=github&amp;utm_medium=shields">
        <img src="https://repo.pkgkit.com/4GBWO/awes-io/navigator/badges/master/coverage.svg" alt="Coverage report" >
    </a>
    <a href="https://www.awes.io/?utm_source=github&amp;utm_medium=shields">
        <img src="https://www.pkgkit.com/4GBWO/awes-io/navigator/version.svg" alt="Last version" >
    </a>
    <a href="https://www.awes.io/?utm_source=github&amp;utm_medium=shields">
        <img src="https://repo.pkgkit.com/4GBWO/awes-io/navigator/badges/master/build.svg" alt="Build status" >
    </a>
    <a href="https://www.awes.io/?utm_source=github&amp;utm_medium=shields">
        <img src="https://www.pkgkit.com/4GBWO/awes-io/navigator/downloads.svg" alt="Downloads" >
    </a>
    <a href="https://www.awes.io/?utm_source=github&amp;utm_medium=shields">
        <img src="https://img.shields.io/github/license/awes-io/navigator.svg" alt="License" />
    </a>
    <a href="https://www.awes.io/?utm_source=github&amp;utm_medium=shields">
        <img src="https://www.pkgkit.com/4GBWO/awes-io/navigator/status.svg" alt="CDN Ready" /> 
    </a>
    <a href="https://www.awes.io/?utm_source=github&amp;utm_medium=shields" target="_blank">
        <img src="https://static.pkgkit.com/badges/laravel.svg" alt="laravel" />
    </a>
    <a href="https://www.awes.io/?utm_source=github&amp;utm_medium=shields">
        <img src="https://img.shields.io/github/last-commit/awes-io/navigator.svg" alt="Last commit" />
    </a>
    <a href="https://github.com/awes-io/awes-io">
        <img src="https://ga-beacon.appspot.com/UA-134431636-1/awes-io/navigator" alt="Analytics" />
    </a>
    <a href="https://www.pkgkit.com/?utm_source=github&amp;utm_medium=shields">
        <img src="https://www.pkgkit.com/badges/hosted.svg" alt="Hosted by Package Kit" />
    </a>
    <a href="https://www.patreon.com/join/awesdotio">
        <img src="https://static.pkgkit.com/badges/patreon.svg" alt="Patreon" />
    </a>
</p>

##
<p align="center">
    <img src="https://static.awes.io/github/repository-cover.png" alt="Repository Laravel" />
</p>


## Table of Contents

- <a href="#installation">Installation</a>
- <a href="#configuration">Configuration</a>
- <a href="#usage">Usage</a>
- <a href="#testing">Testing</a>

## Installation

Via Composer

``` bash
$ composer require awes-io/navigator
```

The package will automatically register itself.

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --provider="AwesIO\Navigator\NavigatorServiceProvider" --tag="config"
```

You can rename any options keys, which are used to get respective data from the menu's config:

```php
// navigator.php config
'keys' => [
    'depth' => 'depth', // rendering depth
    'order' => 'order', // ordering by parameter
    'children' => 'children', // sub menu items
    'route' => 'route', // route name
    'link' => 'link', // item link url
    'title' => 'name', // item title
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

You can achieve same effect dynamically, via mappings mentioned above:

```php
$menu = buildMenu(config('navigation.menu'), ['children' => 'other-children']);
```

Note that we now use global helper method `buildMenu()`.

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

The coverage of the package is <a href="https://www.awes.io/?utm_source=github&amp;utm_medium=shields"><img src="https://repo.pkgkit.com/4GBWO/awes-io/navigator/badges/master/coverage.svg" alt="Coverage report"></a>.

You can run the tests with:

```bash
composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Credits

- [Alexander Osokin](https://thealex.ru)
- [Galymzhan Begimov](https://github.com/begimov)
- [All Contributors][link-contributors]

## License

[MIT](http://opensource.org/licenses/MIT)

<p align="center">
    <a href="https://www.awes.io/?utm_source=github&utm_medium=navigator" target="_blank" rel="noopener noreferrer">
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
    <img src="https://static.awes.io/github/navigator-cover_3.png" alt="Navigator Laravel" />
</p>


## Table of Contents

- <a href="#installation">Installation</a>
- <a href="#quickstart">Quickstart</a>
- <a href="#configuration">Configuration</a>
- <a href="#usage">Usage</a>
- <a href="#permissions">Permissions</a>
- <a href="#testing">Testing</a>

## Installation

Via Composer

``` bash
$ composer require awes-io/navigator
```

The package will automatically register itself.

## Quickstart

Let's firstly create basic navigation, which covers most of the use cases.

Create navigation configuration file:

```php
// config/navigation.php

return [
    [
        'name' => 'Projects',
        'route' => 'projects.index', // route must exist or item will be hidden
        'children' => 
        [
            [
                'name' => 'New projects',
                'link' => '/projects/new', // you can use direct links
            ]
        ]
    ],
    [
        'name' => 'Packages',
        'route' => 'packages.index',
    ]
];
```

Next, let's build our menu somewhere in the controller and pass it to a view:

```php
$menu = buildMenu(config('navigation'));
return view('menu', compact('menu'));
```

And finally implement basic rendering logic:

```php
// menu.blade.php
@foreach($menu as $item)
  <ul>
    <li>
        @if($item->link())
            <a href="{{$item->link()}}">
              @if($item->isActive()) ACTIVE @endif {{$item->name}}
            </a>
        @else
            {{$item->name}}
        @endif
    </li>
    @if($item->hasChildren())
       @include('menu', ['menu' => $item->children()])
    @endif
  </ul>
@endforeach
```

That's all that simple!

## Configuration

You can publish the config file:

```bash
php artisan vendor:publish --provider="AwesIO\Navigator\NavigatorServiceProvider" --tag="config"
```

And rename any options keys, which are used to get respective data from the menu config:

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

As well as use alternative menu settings for parsing and rendering:

```php
// navigator.php config
'keys' => [
    ...
    'children' => 'other-children', // alternative sub menu items
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

You can achieve the same effect dynamically, via mappings mentioned above:

```php
$menu = buildMenu(config('navigation.menu'), [], ['children' => 'other-children']);
```

Note that we now use the global helper method `buildMenu()`.

## Usage

```php
use AwesIO\Navigator\Facades\Navigator;

$menu = Navigator::buildMenu(config('navigation.menu'), ['depth' => 2], [], function ($item) {
    $item->put('meta', $item->get('title') . ' / ' . $item->get('link'));
});

// using helper, rendering depth set via config as a second parameter
$menu = buildMenu(config('navigation.menu'), ['depth' => 2], [], function ($item) {});
```

The first parameter is the menu config in the form of an array:

```php
// navigation.php
return [
    'menu' => [
        [
            'title' => 'Products', // menu item's title
            'route' => 'products.index', // route name for URL generation
            'order' => 1, // parameter to determine the order
            'depth' => 1, // depth for the recursive generation of descendants
            'children' => 
            [
                [
                    'id' => 1, // custom id which overwrites auto-generated one
                    'title' => 'Catalog',
                    'link' => 'products/catalog', // explicit relative path for link URL 
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

Second is config, the third one is mappings for configuration parameters (described above), last is a callback, which will be applied to each menu item.

### Some helpful methods

Determine if the node has any children and retrieve them:

```php
$menu->hasChildren();
$menu->children();
```

Get a link URL for a node:

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

## Menu rendering example

```php
// somewhere in a controller
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

## Permissions

If the user is not authorized to access some of the menu routes, they'll be automatically hidden based on existing permissions:

```php
Route::group(['middleware' => ['can:manage users']], function () {
    Route::get('/', 'RoleController@index')->name('admin.roles.index');
});

// will be excluded from the menu for non-admin users
[
    'name' => __('navigation.security'),
    'icon' => 'twousers',
    'route' => 'admin.roles.index',
],
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

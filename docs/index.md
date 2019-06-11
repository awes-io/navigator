# Navigator

Laravel package which can easily create a navigation menu of any complexity, with support for user permissions when displayed.

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

You can run the tests with:

```bash
composer test
```
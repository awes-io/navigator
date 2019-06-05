<?php

namespace AwesIO\Navigator;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;

class ProcessNavigation
{

    /**
     * @var Collection
     */
    private $item;

    public function __invoke($item)
    {
        $this->item = collect($item);

        $this->processRoute();
        return $this->execute();
    }

    private function processRoute()
    {
        $route = $this->item->get('route');
        if ($route && Route::has($route)) {
            $this->item->put('link', route($route));
        }
    }

    private function transformItem(Collection $item)
    {
        return $item->only('link', 'title');
//        return [
//            'link' => $item->get('link'),
//            'title' => $item->get('title'),
//            'class' => $item->get('active', 'notactive')
//        ];
    }

    private function execute()
    {
        $item = $this->item;
        $child = $item->pull('children');

        $item = $this->transformItem($item);

        if ($child) {
            $item->put('children', $child);
        }
        return $item;
    }

}

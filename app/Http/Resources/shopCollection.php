<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class shopCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($shop) {
            return [
                'url' => getLocale() . "/store/" . $shop->slug,
                'img' => path($shop->img),
                'title' => getLocale() == 'ar' ? "عروض وكوبونات" . " " . $shop->name : "Offers and coupons" . " " .$shop->name,
            ];
        });
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function test()
    {
        $products = [
            ['name' => 'Notebook Mac', 'price' => 2000],
            ['name' => 'Notebook PC', 'price' => 1000],
            ['name' => 'Mouse XYX', 'price' => 50],
        ];

        $products = collect($products);

        dump($products->pluck('name'));
    }
}

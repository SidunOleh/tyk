<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryTag;
use App\Models\Promotion;

class HomeController extends Controller
{
    public function __invoke()
    {
        $tags = CategoryTag::orderByRaw('-category_tags.order DESC')
            ->get();
        $zaklady = Category::establishment()
            ->visible()
            ->orderBy('order', 'ASC')
            ->get();
        $promotions = Promotion::all();

        return view('pages.home', [
            'tags' => $tags,
            'zaklady' => $zaklady,
            'promotions' => $promotions,
        ]);
    }
}

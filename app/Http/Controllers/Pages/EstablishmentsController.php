<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryTag;

class EstablishmentsController extends Controller
{
    public function __invoke()
    {
        $tags = CategoryTag::orderByRaw('-category_tags.order DESC')
            ->get();
        $zaklady = Category::establishment()
            ->visible()
            ->orderBy('order', 'ASC')
            ->get();

        return view('pages.establishments', [
            'tags' => $tags,
            'zaklady' => $zaklady,
        ]);
    }
}

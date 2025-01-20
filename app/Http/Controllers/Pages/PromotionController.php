<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Promotion;

class PromotionController extends Controller
{
    public function __invoke(Promotion $promotion)
    {
        $promotions = Promotion::all();

        return view('pages.promotion', [
            'promotion' => $promotion,
            'promotions' => $promotions,
        ]);
    }
}

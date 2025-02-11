<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Services\Options\OptionService;
use Illuminate\Http\Request;

class SaveController extends Controller
{
    public function __construct(
        public OptionService $optionService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $this->optionService->save('content', json_encode($request->all()));
        
        return response(['message' => 'OK',]);
    }
}

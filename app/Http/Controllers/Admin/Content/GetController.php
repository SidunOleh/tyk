<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Services\Options\OptionService;

class GetController extends Controller
{
    public function __construct(
        public OptionService $optionService
    )
    {
        
    }

    public function __invoke()
    {
        $content = $this->optionService->get('content');
        $content = json_decode($content, true);

        return response($content);
    }
}

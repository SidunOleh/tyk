<?php

namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Images\UploadRequest;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        $path = $request->image->store();

        $fullPath = "/storage/{$path}";

        return response(['path' => $fullPath,]);
    }
}

<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\HandleRequest;
use App\Mail\FormMail;
use Illuminate\Support\Facades\Mail;

class HandleController extends Controller
{
    public function __invoke(HandleRequest $request)
    {
        Mail::to('deliverytyk2017@gmail.com')->send(new FormMail($request->all()));

        return response(['message' => 'OK',]);
    }
}

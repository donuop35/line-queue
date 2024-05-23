<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class LineBotController extends Controller
{
    public function reply(Request $request)
    {
        Log::info($request->all());

        return response('HTTP_OK', Response::HTTP_OK);
    }
}

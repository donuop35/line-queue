<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LineBotController extends Controller
{
    public function reply(Request $request): void
    {
        Log::info($request->all());
        $text = $request->all();
        $line_bot = new \App\Service\LineBotService;

        // 中文驗證過不了
        throw_if(
            $line_bot->hashNotEquals(json_encode($request->all()), $_SERVER['HTTP_X_LINE_SIGNATURE']),
            new Exception('403 Forbidden'),
        );

        $respond_type = $line_bot->parseLineEvents($text);

        function_exists('reply' . ucfirst($respond_type))
            ? $line_bot->{'reply' . ucfirst($respond_type)}($text['events'][0]['replyToken'])
            : $line_bot->replyMPDefaultNote($text['events'][0]['replyToken']);
    }
}

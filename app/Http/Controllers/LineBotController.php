<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use Spatie\Crawler\Crawler;
use LINE\LINEBot\EchoBot;
use GuzzleHttp;

class LineBotController extends Controller
{
    private $access_token;
    private $channel_secret;

    public function __construct()
    {
        $this->access_token = config('line.access_token', '9a4f36cd6f7b567a754c662b2b6522e8');
        $this->channel_secret = config('line.channel_secret', 'swXFvPBV92OcjCw4EnhTuqWhJ69zUfbku9yb2AqpnevWrjIXeYTY+ELAsiBDEwNtcgEj0uC5JV5/SucXFZVPxy7KSp/wh6Bgw35bpDflMEmPlLSw8MkvFEIFJ5IHe9BKd5UvxJQDThr1hEA1lWtMVAdB04t89/1O/w1cDnyilFU=');
    }

    public function reply(Request $request)
    {
        Log::info($request->all());
        Log::info($this->access_token);
        Log::info($this->channel_secret);
    }

    // public function reply(Request $request)
    // {
    //     $client = new \GuzzleHttp\Client();
    //     $config = new \LINE\Clients\MessagingApi\Configuration();
    //     $config->setAccessToken('swXFvPBV92OcjCw4EnhTuqWhJ69zUfbku9yb2AqpnevWrjIXeYTY+ELAsiBDEwNtcgEj0uC5JV5/SucXFZVPxy7KSp/wh6Bgw35bpDflMEmPlLSw8MkvFEIFJ5IHe9BKd5UvxJQDThr1hEA1lWtMVAdB04t89/1O/w1cDnyilFU=');

    //     $messagingApi = new \LINE\Clients\MessagingApi\Api\MessagingApiApi(
    //         client: $client,
    //         config: $config,
    //     );

    //     $message = new TextMessage(['type' => 'text','text' => 'hello!']);
    //     $request = new ReplyMessageRequest([
    //         'replyToken' => '<reply token>',
    //         'messages' => [$message],
    //     ]);
    //     $response = $messagingApi->replyMessage($request);
    // }

    // public function reply(Request $request)
    // {
    //     $httpClient = new CurlHTTPClient('swXFvPBV92OcjCw4EnhTuqWhJ69zUfbku9yb2AqpnevWrjIXeYTY+ELAsiBDEwNtcgEj0uC5JV5/SucXFZVPxy7KSp/wh6Bgw35bpDflMEmPlLSw8MkvFEIFJ5IHe9BKd5UvxJQDThr1hEA1lWtMVAdB04t89/1O/w1cDnyilFU=');
    //     $bot = new LINEBot($httpClient, ['channelSecret' => env('9a4f36cd6f7b567a754c662b2b6522e8')]);
    //     $httpClient = new CurlHTTPClient(env('LINE_BOT_CHANNEL_ACCESS_TOKEN'));
    //     $bot = new LINEBot($httpClient, ['channelSecret' => env('LINE_BOT_CHANNEL_SECRET')]);

    //     try {
    //         $bot->parseEventRequest($request->getContent(), $request->header('X-Line-Signature'));
    //     }catch (LINEBot\Exception\InvalidSignatureException $exception){
    //         return response('An exception class that is raised when signature is invalid.',Response::HTTP_FORBIDDEN);
    //     }catch (LINEBot\Exception\InvalidEventRequestException $exception){
    //         return response('An exception class that is raised when received invalid event request.',Response::HTTP_FORBIDDEN);
    //     }

    //     $text = $request['events'][0]['message']['text'];
    //     $replyToken = $request['events'][0]['replyToken'];
    //     $response = $bot->replyText($replyToken, $text);

    //     if ($response->isSucceeded()){
    //         return response('HTTP_OK', Response::HTTP_OK);
    //     }else{
    //         Log::debug($response->getHTTPStatus());
    //         Log::debug($response->getRawBody());
    //         return response('HTTP_UNPROCESSABLE_ENTITY', Response::HTTP_UNPROCESSABLE_ENTITY);
    //     }
    // }
}

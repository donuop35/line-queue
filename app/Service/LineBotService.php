<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;

class LineBotService
{
    private $access_token;
    private $channel_secret;

    public function __construct()
    {
        $this->access_token = config('line.access_token', '9a4f36cd6f7b567a754c662b2b6522e8');
        $this->channel_secret = config('line.channel_secret', 'swXFvPBV92OcjCw4EnhTuqWhJ69zUfbku9yb2AqpnevWrjIXeYTY+ELAsiBDEwNtcgEj0uC5JV5/SucXFZVPxy7KSp/wh6Bgw35bpDflMEmPlLSw8MkvFEIFJ5IHe9BKd5UvxJQDThr1hEA1lWtMVAdB04t89/1O/w1cDnyilFU=');
    }

    private function replyByLineAPI($message): void
    {
        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->access_token,
        ];

        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true,
                'method' => 'POST',
                'header' => implode("\r\n", $header),
                'content' => json_encode($message),
            ],
        ]);

        $response = file_get_contents('https://api.line.me/v2/bot/message/reply', false, $context);
        Log::info($response);
        if (strpos($http_response_header[0], '200') === false) {
            error_log('Request failed: ' . $response);
        }
    }

    public function parseLineEvents($message): string
    {
        return $message['events'][0]['type'] === 'message'
            ? $message['events'][0]['message']['text']
            : $message['events'][0]['type'];
    }

    public function replyMessage($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'text',   //訊息類型 [文字)
                    'text' => 'Hello, world!',  // 回覆訊息
                ]
            ],
        ]);
    }

    public function replyImage($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'image',  // 訊息類型 [圖片)
                    'originalContentUrl' => 'https://i.imgur.com/rN1sZdq.jpg',  // 回覆圖片
                    'previewImageUrl' => 'https://i.imgur.com/rN1sZdq.jpg', // 回覆的預覽圖片
                ],
            ],
        ]);
    }

    public function replyVideo($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'video',  //訊息類型 [影片)
                    'originalContentUrl' => 'https://i.imgur.com/KAODmRm.mp4',  // 回覆影片
                    'previewImageUrl' => 'https://i.imgur.com/jyIiu87.jpg', // 回覆的預覽圖片
                ],
            ],
        ]);
    }

    public function replyAudio($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'audio',  // 訊息類型 [音樂)
                    'originalContentUrl' => 'https://i.imgur.com/XPP92gT.mp4',  // 回覆音樂
                    'duration' => 95000,    // 音樂長度 [毫秒)
                ],
            ],
        ]);
    }

    // 待研究格式
    public function replyFlex($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'flex',   // 訊息類型 [flex)
                    'altText' => 'Example flex message template',   // 替代文字
                    'contents' => [   // Flex Message 內容
                        'type' => 'bubble',
                        'hero' => [
                            'type' => 'image',
                            'url' => 'https://i.imgur.com/cY1BdiQ.jpg',
                            'aspectRatio' => '16:9',
                            'size' => 'full',
                            'aspectMode' => 'cover',
                        ],
                        'body' => [
                            'type' => 'box',
                            'layout' => 'vertical',
                            'contents' => [
                                [
                                    'type' => 'text',
                                    'text' => '毛孩噗，歡迎你!',
                                    'weight' => 'bold',
                                    'size' => 'xl',
                                    'margin' => 'md',
                                    'wrap' => true,
                                ],
                                [
                                    'type' => 'text',
                                    'text' => 'Hello, world!',
                                    'wrap' => true,
                                    'color' => '#e96bff',
                                ],
                            ],
                        ],
                        'footer' => [
                            'type' => 'box',
                            'layout' => 'vertical',
                            'contents' => [
                                [
                                    'type' => 'button',
                                    'action' => [
                                        'type' => 'uri',
                                        'label' => '教學文章',
                                        'uri' => 'https://blog.reh.tw/archives/988#Flex-%E8%A8%8A%E6%81%AF',
                                    ],
                                    'style' => 'secondary',
                                    'color' => '#FFD798',
                                ],
                                [
                                    'type' => 'button',
                                    'action' => [
                                        'type' => 'uri',
                                        'uri' => 'https://github.com/GoneToneStudio/line-example-bot-tiny-php',
                                        'label' => 'GitHub'
                                    ],
                                ],
                            ],
                        ],
                        'size' => 'giga',
                    ],
                ],
            ],
        ]);
    }

    public function replyButtons($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'template',   // 訊息類型 [模板]
                    'altText' => 'Example buttons template',    // 替代文字
                    'template' => [
                        'type' => 'buttons',    // 類型 [按鈕]
                        'thumbnailImageUrl' => 'https://i.imgur.com/jWVeCFO.jpg', // 圖片網址 <不一定需要>
                        'title' => 'Example Menu',  // 標題 <不一定需要>
                        'text' => 'Please select',  // 文字
                        'actions' => [
                            [
                                'type' => 'postback',   // 類型 [回傳]
                                'label' => 'Postback example',  // 標籤 1
                                'data' => 'action=buy&itemid=123',   // 資料
                            ],
                            [
                                'type' => 'message',    // 類型 [訊息]
                                'label' => 'Message example',   // 標籤 2
                                'text' => 'Message example', // 用戶發送文字
                            ],
                            [
                                'type' => 'uri',    // 類型 [連結]
                                'label' => 'Uri example',   // 標籤 3
                                'uri' => 'https://github.com/GoneToneStudio/line-example-bot-tiny-php',  // 連結網址
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function replyConfirm($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'template',   // 訊息類型 [模板]
                    'altText' => 'Example confirm template',    // 替代文字
                    'template' => [
                        'type' => 'confirm',    // 類型 [確認]
                        'text' => 'Are you sure?',  // 文字
                        'actions' => [
                            [
                                'type' => 'message',    // 類型 [訊息]
                                'label' => 'Yes',   // 標籤 1
                                'text' => 'Yes' // 用戶發送文字 1
                            ],
                            [
                                'type' => 'message',    //類型 [訊息]
                                'label' => 'No',    // 標籤 2
                                'text' => 'No', // 用戶發送文字 2
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function replyCarousel($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'template',   // 訊息類型 [模板]
                    'altText' => 'Example buttons template',    // 替代文字
                    'template' => [
                        'type' => 'carousel',   // 類型 [輪播]
                        'columns' => [
                            [
                                'thumbnailImageUrl' => 'https://i.imgur.com/Ddpwv7G.jpg', // 圖片網址 <不一定需要>
                                'title' => 'Example Menu 1',    // 標題 1 <不一定需要>
                                'text' => 'Description 1',  // 文字 1
                                'actions' => [
                                    [
                                        'type' => 'postback',   // 類型 [回傳]
                                        'label' => 'Postback example 1',    // 標籤 1
                                        'data' => 'action=buy&itemid=123'   // 資料
                                    ],
                                    [
                                        'type' => 'message',    // 類型 [訊息]
                                        'label' => 'Message example 1', // 標籤 2
                                        'text' => 'Message example 1'   // 用戶發送文字
                                    ],
                                    [
                                        'type' => 'uri',    // 類型 [連結]
                                        'label' => 'Uri example 1', // 標籤 3
                                        'uri' => 'https://github.com/GoneToneStudio/line-example-bot-tiny-php'  //連結網址
                                    ],
                                ],
                            ],
                            [
                                'thumbnailImageUrl' => 'https://i.imgur.com/KjzmYTO.jpg', // 圖片網址 <不一定需要>
                                'title' => 'Example Menu 2',    // 標題 2 <不一定需要>
                                'text' => 'Description 2',  // 文字 2
                                'actions' => [
                                    [
                                        'type' => 'postback',   // 類型 [回傳]
                                        'label' => 'Postback example 2',    // 標籤 2
                                        'data' => 'action=buy&itemid=123'   // 資料
                                    ],
                                    [
                                        'type' => 'message',    // 類型 [訊息]
                                        'label' => 'Message example 2', // 標籤 2
                                        'text' => 'Message example 2'   // 用戶發送文字
                                    ],
                                    [
                                        'type' => 'uri',    // 類型 [連結]
                                        'label' => 'Uri example 2', // 標籤 2
                                        'uri' => 'https://github.com/GoneToneStudio/line-example-bot-tiny-php'  // 連結網址
                                    ],
                                ],
                            ],
                            [
                                'thumbnailImageUrl' => 'https://i.imgur.com/1tqygt7.jpg', // 圖片網址 <不一定需要>
                                'title' => 'Example Menu 3',    // 標題 3 <不一定需要>
                                'text' => 'Description 3',  // 文字 3
                                'actions' => [
                                    [
                                        'type' => 'postback',   // 類型 [回傳]
                                        'label' => 'Postback example 3',    // 標籤 3
                                        'data' => 'action=buy&itemid=123'   // 資料
                                    ],
                                    [
                                        'type' => 'message',    // 類型 [訊息]
                                        'label' => 'Message example 3', // 標籤 3
                                        'text' => 'Message example 3'   // 用戶發送文字
                                    ],
                                    [
                                        'type' => 'uri',    // 類型 [連結]
                                        'label' => 'Uri example 3', // 標籤 3
                                        'uri' => 'https://github.com/GoneToneStudio/line-example-bot-tiny-php'  // 連結網址
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function replyImageCarousel($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'template',   // 訊息類型 [模板]
                    'altText' => 'Example image carousel template', // 替代文字
                    'template' => [
                        'type' => 'image_carousel', // 類型 [圖片輪播]
                        'columns' => [
                            [
                                'imageUrl' => 'https://i.imgur.com/EUPxEXy.jpg',    // 圖片網址
                                'action' => [
                                    'type' => 'postback',   // 類型 [回傳]
                                    'label' => 'Pb example',    // 標籤
                                    'data' => 'action=buy&itemid=123',  // 資料
                                ],
                            ],
                            [
                                'imageUrl' => 'https://i.imgur.com/pyxSfOF.jpg',    // 圖片網址
                                'action' => [
                                    'type' => 'message',    // 類型 [訊息]
                                    'label' => 'Msg example',   // 標籤
                                    'text' => 'Message example',    // 用戶發送文字
                                ],
                            ],
                            [
                                'imageUrl' => 'https://i.imgur.com/MkSIV2e.jpg',    // 圖片網址
                                'action' => [
                                    'type' => 'uri',    // 類型 [連結]
                                    'label' => 'Uri example',   // 標籤
                                    'uri' => 'https://github.com/GoneToneStudio/line-example-bot-tiny-php', // 連結網址
                                ],
                            ],
                        ],
                    ]
                ],
            ],
        ]);
    }

    public function replySticker($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'sticker',    // 訊息類型 [貼圖]
                    'packageId' => 1,   // 貼圖包 ID
                    'stickerId' => 5,   // 貼圖 ID
                ],
            ],
        ]);
    }

    public function replyLocation($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'location',   // 訊息類型 (位置)
                    'title' => 'Example location',  // 回覆標題
                    'address' => '台灣台中市西屯區西屯路三段宏福五巷22號4樓',   // 回覆地址
                    'latitude' => 24.187965816739943,    // 地址緯度
                    'longitude' => 120.61566746881161,   // 地址經度
                ],
            ],
        ]);
    }

    public function replyImageMap($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'imagemap',   // 訊息類型 (圖片地圖)
                    'baseUrl' => 'https://i.imgur.com/ImMVhAj.jpg',    // 圖片網址 (可調整大小 240px, 300px, 460px, 700px, 1040px)
                    'altText' => 'Example imagemap',    // 替代文字
                    'baseSize' => [
                        'height' => 1040,   // 圖片寬
                        'width' => 1040,    // 圖片高
                    ],
                    'actions' => [
                        [
                            'type' => 'uri',    // 類型 (網址)
                            'linkUri' => 'https://github.com/GoneToneStudio/line-example-bot-tiny-php',  // 連結網址
                            'area' => [
                                'x' => 0,   // 點擊位置 X 軸
                                'y' => 0,   // 點擊位置 Y 軸
                                'width' => 520, // 點擊範圍寬度
                                'height' => 1040,   // 點擊範圍高度
                            ],
                        ],
                        [
                            'type' => 'message',    // 類型 (用戶發送訊息)
                            'text' => 'Welcome Maw and Paw!',  // 發送訊息
                            'area' => [
                                'x' => 520, // 點擊位置 X 軸
                                'y' => 0,   // 點擊位置 Y 軸
                                'width' => 520, // 點擊範圍寬度
                                'height' => 1040,   // 點擊範圍高度
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function replyMPDefaultNote($token): void
    {
        $this->replyByLineAPI([
            'replyToken' => $token,
            'messages' => [
                [
                    'type' => 'text',   // 訊息類型 (文字)
                    'text' => '請說人話，謝謝d(`･∀･)b',  // 回覆訊息
                ],
            ],
        ]);
    }

    public function hashNotEquals($request_string, $user_string): bool
    {
        $known_string = $this->sign($request_string);

        // Compare string lengths
        if (($length = strlen($known_string)) !== strlen($user_string)) {
            return false;
        }

        $diff = 0;

        // Calculate differences
        for ($i = 0; $i < $length; $i++) {
            $diff |= ord($known_string[$i]) ^ ord($user_string[$i]);
        }

        return $diff !== 0;
    }

    private function sign($body): string
    {
        return base64_encode(
            hash_hmac('sha256', $body, $this->channel_secret, true)
        );
    }
}

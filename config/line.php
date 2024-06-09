<?php

return [
    'channel_id' => env('LINE_CHANNEL_ID'),
    'channel_secret' => env('LINE_CHANNEL_SECRET'),
    'access_token' => env('LINE_ACCESS_TOKEN'),
    'authorize_url'=>'https://access.line.me/oauth2/v2.1/authorize',
    'get_token_url' => 'https://api.line.me/oauth2/v2.1/token',
    'get_user_profile_url' => 'https://api.line.me/v2/profile',
    'get_user_verify_url' => 'https://api.line.me/oauth2/v2.1/verify'
];

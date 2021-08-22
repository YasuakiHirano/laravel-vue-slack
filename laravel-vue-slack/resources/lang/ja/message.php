<?php

return [
    'user_not_found' => 'ユーザーが見つかりませんでした。招待メールを受け取ってアカウントを作成してください。',
    'mail' => [
        'invitation' => [
            'title' => "LaravelVueSlackへの招待メール",
            'content' => env('APP_NAME')."に招待されています。\n下記にアクセスして、登録を完了させてください。\n:url"
        ]
    ]
];

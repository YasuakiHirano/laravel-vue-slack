<?php

return [
    'user_not_found' => 'ユーザーが見つかりませんでした。メールアドレスかパスワードが間違っています。',
    'mail' => [
        'invitation' => [
            'title' => "LaravelVueSlackへの招待メール",
            'content' => env('APP_NAME')."に招待されています。\n下記にアクセスして、登録を完了させてください。\n:url"
        ]
    ]
];

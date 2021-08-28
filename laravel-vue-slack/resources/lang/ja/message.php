<?php

return [
    'user_not_found' => 'ユーザーが見つかりませんでした。メールアドレスかパスワードが間違っています。',
    'mail' => [
        'invitation' => [
            'title' => "LaravelVueSlackへの招待メール",
            'content' => env('APP_NAME')."に招待されています。\n下記にアクセスして、登録を完了させてください。\n:url"
        ]
    ],
    'message' => [
        'parent_message_id_empty' => 'スレッドの親メッセージIDが空です。',
        'other_user_post_delete' => '他のユーザーの投稿は削除できません。'
    ],
    'user' => [
        'unique_email' => 'メールアドレスが既に登録されています。ログインしてください。'
    ]
];

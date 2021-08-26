<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ChannelUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['channel_id', 'user_id'];

    /**
     * チャンネルに関連するユーザー一覧を取得する
     *
     * @param int $channelId
     * @return void
     */
    public function fetchChannelUsers($channelId)
    {
        return $this::select([
                    'users.name',
                    DB::raw("CONCAT('image/user_image_', user_information.image_number, '.png') as \"imagePath\""),
                ])
                ->from('channel_users')
                ->join('users', function($join) {
                    $join->on('users.id', '=', 'channel_users.user_id');
                })
                ->join('user_information', function($join) {
                    $join->on('user_information.user_id', '=', 'channel_users.user_id');
                })
                ->whereChannelId($channelId)
                ->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'make_user_id', 'is_public'];

    /**
     * 指定されたチャンネルID(複数)からチャンネル情報を取得する
     *
     * @param array $channelIds
     * @return void
     */
    public function fetchChannelList($channelIds) {
        return $this::select([
            'channels.id',
            'channels.name',
            'channels.description',
            'users.name as create_user',
            'channels.is_public',
        ])
        ->join('users', function($join) {
            $join->on('users.id', '=', 'channels.make_user_id');
        })
        ->whereIn('channels.id', $channelIds)
        ->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'channel_id', 'content', 'is_thread_message'];

    public function reactions() {
        return $this->hasMany(Reaction::class);
    }

    public function mentions() {
        return $this->hasMany(Mention::class);
    }

    public function createMessageQuery($channelId, $messageIds = null) {
        $query = $this::select([
            'messages.id',
            DB::raw("DATE_FORMAT(messages.created_at, '%Y年%m月%d日') as date"),
            DB::raw("CONCAT('image/user_image_', user_information.image_number, '.png') as imagePath"),
            "users.name as postUserName",
            DB::raw("DATE_FORMAT(messages.created_at, '%H:%i') as postTime"),
            "messages.content",
            DB::raw("(SELECT count(*) FROM threads WHERE parent_message_id = messages.id) as isThreadCount"),
        ])
       ->from('messages')
       ->join('users', function($join) {
           $join->on('users.id', '=', 'messages.user_id');
       })
       ->join('user_information', function($join) {
           $join->on('users.id', '=', 'user_information.user_id');
       });

       if ($messageIds) {
           $query = $query->whereIn('messages.id', $messageIds)
                        ->whereIsThreadMessage(true);
       } else {
           $query = $query->whereChannelId($channelId)
                        ->whereIsThreadMessage(false);
       }

       $query = $query->with('reactions')
       ->with('mentions');

        return $query;
    }

    public function countTodayMessage() {
        return $this::where(DB::raw("DATE_FORMAT(messages.created_at, '%Y-%m-%d')"), '=', Carbon::now()->format('Y-m-d'))->count();
    }
}

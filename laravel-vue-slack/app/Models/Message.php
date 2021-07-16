<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'channel_id', 'content'];

    public function reactions() {
        return $this->hasMany(Reaction::class);
    }

    public function createMessageQuery() {
        return $this::select([
            'messages.id',
            DB::raw("DATE_FORMAT(messages.created_at, '%Y年%m月%d日') as date"),
            DB::raw("CONCAT('image/user_image_', user_information.image_number, '.png') as imagePath"),
            "users.name as postUserName",
            DB::raw("DATE_FORMAT(messages.created_at, '%H:%i') as postTime"),
            "messages.content"
        ])
       ->from('messages')
       ->join('users', function($join) {
           $join->on('users.id', '=', 'messages.user_id');
       })
       ->join('user_information', function($join) {
           $join->on('users.id', '=', 'user_information.user_id');
       })
       ->with('reactions');
    }
}

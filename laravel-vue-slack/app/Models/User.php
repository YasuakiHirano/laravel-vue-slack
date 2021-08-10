<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ChannelUser;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 指定したチャンネルに関連付かないユーザー一覧取得
     *
     * @param int $channelId
     * @return void
     */
    public function fetchNotChannelUsers($channelId)
    {
        $channelUsers = ChannelUser::select(['user_id'])->whereChannelId($channelId)->get();
        return $this::select([
                    'users.id',
                    'users.name',
                    DB::raw("CONCAT('image/user_image_', user_information.image_number, '.png') as imagePath"),
                ])
                ->from('users')
                ->join('user_information', function($join) {
                    $join->on('users.id', '=', 'user_information.user_id');
                })
                ->whereNotIn('users.id', $channelUsers->pluck('user_id'))
                ->get();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Channel;
use App\Models\ChannelUser;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultChannel = Channel::whereName('general')->first();

        if (is_null($defaultChannel)) {
            Channel::create([
                'name' => 'general',
                'description' => 'システムのデフォルトチャンネルです。',
                'make_user_id' => 1,
                'is_public' => config('const.channel.public'),
            ]);
        } else {
            $this->command->error('!!! デフォルトのチャンネル(general)が既に追加されています。 !!!');
        }

        $defaultChannelUser = ChannelUser::whereUserId(1)->first();

        if (is_null($defaultChannelUser)) {
            ChannelUser::create([
                'channel_id' => 1,
                'user_id' => 1,
            ]);
        } else {
            $this->command->error('!!! デフォルトのチャンネルユーザーが既に追加されています。 !!!');
        }
    }
}

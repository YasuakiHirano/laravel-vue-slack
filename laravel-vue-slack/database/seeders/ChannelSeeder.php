<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Channel;

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
                'is_public' => config('constant.channel.public'),
            ]);
        } else {
            $this->command->error('!!! デフォルトのチャンネル(general)が既に追加されています。 !!!');
        }
    }
}

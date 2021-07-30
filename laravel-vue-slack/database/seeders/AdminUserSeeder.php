<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserInformation;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::where('email', 'admin@example.com')->first();

        if (is_null($adminUser)) {
            User::create([
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
        } else {
            $this->command->error('!!! 管理ユーザーが既に追加されています。 !!!');
        }

        $adminUserInformation = UserInformation::whereUserId(1)->first();
        if (is_null($adminUserInformation)) {
            UserInformation::create([
                'user_id' => 1,
                'image_number' => 1,
                'status' => config('const.user_status.registered'),
            ]);
        } else {
            $this->command->error('!!! 管理ユーザーが既に追加されています。 !!!');
        }
    }
}

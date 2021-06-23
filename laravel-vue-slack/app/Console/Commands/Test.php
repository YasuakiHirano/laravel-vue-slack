<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->test3('111fuga', '1112@example.com', 'password');
        return 0;
    }

    private function test1()
    {
        echo "---- start test1 ---\n";
        try {
            DB::beginTransaction();

            User::create([
                'name'     => 'taro',
                'email'    => 'hoge2@example.com',
                'password' => 'password'
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }
        echo "---- end test1 ---\n";
    }

    private function test2()
    {
        echo "---- start test2 ---\n";
        DB::transaction(function () {
            User::create([
                'name'     => 'taro',
                'email'    => 'hoge'.mt_rand(0, 1000).'@example.com',
                'password' => 'password'
            ]);
        });
        echo "---- end test2 ---\n";
    }

    private function test3($name, $email, $password)
    {
        echo "---- start test3 ---\n";
        try {
        DB::transaction(function () use($name, $email, $password) {
            User::create([
                'name'     => $name,
                'email'    => $email,
                'password' => $password
            ]);
            throw new \Exception("hogehoge");
        });
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        echo "---- end test3 ---\n";
    }
}

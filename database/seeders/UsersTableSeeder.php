<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * 開発用にテスト用ユーザーを作成する
     *
     * @return void
     */
    public function run()
    {
        // 日本語でテスト用データを作成
        $faker = Faker::create('ja_JP');

        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'url_name' => $faker->unique()->userName,
            ]);
        }
    }
}

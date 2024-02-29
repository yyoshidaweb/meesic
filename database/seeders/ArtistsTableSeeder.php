<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtistsTableSeeder extends Seeder
{
    /**
     * 開発用にテスト用アーティストを作成する
     *
     * @return void
     */
    public function run()
    {
        // 日本語でテスト用データを作成
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            DB::table('artists')->insert([
                'user_id' => rand(1, 10),
                'name' => $faker->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 開発用にテスト用ユーザーとテスト用アーティストを作成する
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class, [
            'validate' => true,
        ]);

        $this->call(ArtistsTableSeeder::class, [
            'validate' => true,
        ]);
    }
}

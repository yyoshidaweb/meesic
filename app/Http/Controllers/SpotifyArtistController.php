<?php

namespace App\Http\Controllers;

use App\Models\SpotifyArtist;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SpotifyArtistController extends Controller
{
    /**
     * Spotify APIのアクセストークンを取得し、暗号化し、sessionに保存する。
     *
     * @return void
     */
    public function getAccessToken()
    {
        // リクエストパラメータ
        $params = [
            'grant_type' => 'client_credentials',
        ];
        // Guzzleクライアントを作成
        $client = new \GuzzleHttp\Client();
        // GET通信するURL
        $url = 'https://accounts.spotify.com/api/token';
        // Spotify Client ID
        $client_id = config('services.spotify.client_id');
        // Spotify Client secret
        $client_secret = config('services.spotify.client_secret');

        // リクエスト
        $response = $client->request('POST', $url, [
            'form_params' => $params,
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $client_secret),
            ],
        ]);

        // API通信で取得したデータはjson形式なのでPHPファイルに対応した連想配列にデコードする
        $data = json_decode($response->getBody()->getContents(), true);
        // 取得したデータからアクセストークンを取得
        $access_token = $data['access_token'];
        // アクセストークンを暗号化
        $encrypted_access_token = Crypt::encryptString($access_token);
        // 暗号化済みアクセストークンをsessionに保存
        session(['access_token' => $encrypted_access_token]);
    }
}

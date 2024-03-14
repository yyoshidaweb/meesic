<?php

namespace App\Http\Controllers;

use App\Models\SpotifyArtist;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SpotifyArtistController extends Controller
{
    /**
     * Spotify APIのアクセストークンを取得する。
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

        return $access_token;
    }

    /**
     * Spotify IDを元にSpotify上のアーティストデータを取得する
     *
     * @param string $spotify_id
     * @return void
     */
    public function getArtistById(string $spotify_id)
    {
        // クライアントを作成
        $client = new \GuzzleHttp\Client();

        // 新たなアクセストークンを取得する。
        $access_token = $this->getAccessToken();

        // リクエストヘッダー
        $headers = [
            'Authorization' => 'Bearer ' . $access_token,
            'Accept-Language' => 'ja',
        ];
        // 取得したいアーティストのSpotify IDを含めたURL
        $url = 'https://api.spotify.com/v1/artists/' . $spotify_id;
        // リクエストオプション
        $options = [
            'headers' => $headers,
        ];
        // リクエストを実行
        $response = $client->request('GET', $url, $options);
        // アーティストデータを連想配列に変更
        $result_artist = json_decode($response->getBody()->getContents(), true);

        return $result_artist;
    }

    /**
     * Spotify上のアーティストを検索する
     *
     * @param string $key_word
     * @return void
     */
    public function searchArtists(string $keyword)
    {
        // クライアントを作成
        $client = new \GuzzleHttp\Client();

        // 新たなアクセストークンを取得する。
        $access_token = $this->getAccessToken();

        // リクエストヘッダー
        $headers = [
            'Authorization' => 'Bearer ' . $access_token,
            'Accept-Language' => 'ja',
        ];
        // リクエストパラメータ
        $params = [
            'q' => $keyword,
            'type' => 'artist',
            'limit' => '5',
        ];
        // URL
        $url = 'https://api.spotify.com/v1/search';
        // リクエストオプション
        $options = [
            'query' => $params,
            'headers' => $headers,
        ];
        // リクエストを実行
        $response = $client->request('GET', $url, $options);
        // 検索結果を連想配列に変更
        $data = json_decode($response->getBody()->getContents(), true);
        // 検索結果からアーティストデータのみを取得
        $result_artists = $data['artists']['items'];

        // 検索結果を返す
        return $result_artists;
    }
}

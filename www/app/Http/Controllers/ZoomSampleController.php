<?php

namespace App\Http\Controllers;

use App\Enums\CurrentUserType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Class ZoomSampleController
 * @package App\Http\Controllers
 * @see https://developers.zoom.us/docs/integrations/oauth/
 * @see https://jun-app.com/articles/zoom-api-laravel
 */
class ZoomSampleController extends Controller
{
    public function auth()
    {
        $zoomOAuthLink = 'https://zoom.us/oauth/authorize?' . http_build_query([
            'response_type' => 'code',
            'redirect_uri' => env('ZOOM_REDIRECT_URI'),
            'client_id' => env('ZOOM_CLIENT_ID'),
        ]);

        return redirect($zoomOAuthLink);
    }

    // todo: 整形
    public function callback(Request $request)
    {
        $user = User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'status' => CurrentUserType::Counselor,
            'remember_token' => Str::random(10),
        ]);
        // todo: save code
        $code = $request['code'];
        $user->zoom_code = $code;
        $user->save();

        $basic = base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'));
        $client = new \GuzzleHttp\Client([
            'headers' => ['Authorization' => 'Basic ' . $basic]
        ]);

        // request zoom api to get access token
        $res = $client->request('POST', 'https://zoom.us/oauth/token', [
            'query' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => env('ZOOM_REDIRECT_URI')
            ]
        ]);
        $result = json_decode($res->getBody()->getContents());

        // todo: save access token
        $user->access_token = $result->access_token;
        $user->refresh_token = $result->refresh_token;
        $unixTime = time();
        $user->zoom_expires_in = date("Y-m-d H:i:s", $unixTime + $result->expires_in);
        $user->save();

        // redirect to HOME
        return redirect('/sample/api')->with([
            'noZoomCode' => false,
            'oauthSuccess' => true
        ]);
    }

    protected function me()
    {
        $user = User::findOrFail(6);
        $client = new \GuzzleHttp\Client([
            'headers' => ['Authorization' => 'Bearer '.$user->access_token]
        ]);
        dump($user->access_token);
        $res = $client->request('GET','https://api.zoom.us/v2/users/me');
        $result = json_decode($res->getBody()->getContents());

        return $result;
    }

    public function getUser()
    {
        $user = User::findOrFail(6);
        $zoomUser = $this->me();
        dd($user, $zoomUser);
    }

    public function create()
    {
        // todo: create a new meeting

    }

    public function update()
    {
        // todo: update a new meeting

    }

    public function delete()
    {
        // todo: delete a new meeting

    }
}

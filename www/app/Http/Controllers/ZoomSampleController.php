<?php

namespace App\Http\Controllers;

use App\Enums\CounselingStatus;
use App\Enums\CurrentUserType;
use App\Models\Counseling;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * Class ZoomSampleController
 * @package App\Http\Controllers
 * @see https://developers.zoom.us/docs/integrations/oauth/
 * @see https://jun-app.com/articles/zoom-api-laravel
 */
class ZoomSampleController extends Controller
{
    private $ZoomUserID = 4;

    public function index()
    {
        $user = User::findOrFail($this->ZoomUserID);
        $zoomUser = $this->me();

        // Zoom MT取得
        $from = now()->format('Y-m-d');
        $to = now()->addCentury()->format('Y-m-d');
        // NOTE: 現在以降のMeeting取得にはfromに加えてto, timezone が必要
        $url = 'https://api.zoom.us/v2/users/' . $zoomUser->id . '/meetings?from=' . $from . '&to=' . $to . '&timezone=Asia/Tokyo';
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $user->access_token,
                'Content-Type' => 'application/json',
            ],
        ]);
        $res = $client->request('GET', $url);
        $result = json_decode($res->getBody()->getContents());

        // view
        return view('sample.api.zoom-index', [
            'meetings' => $result->meetings,
        ]);
    }

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
            'headers' => ['Authorization' => 'Basic ' . $basic],
        ]);

        // request zoom api to get access token
        $res = $client->request('POST', 'https://zoom.us/oauth/token', [
            'query' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => env('ZOOM_REDIRECT_URI'),
            ],
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
            'oauthSuccess' => true,
        ]);
    }

    public function getUser()
    {
        // Zoom OAuth済みのユーザー取得
        $user = User::findOrFail($this->ZoomUserID);
        $zoomUser = $this->me();
        dd($user, $zoomUser);
    }

    public function create()
    {
        // Zoom OAuth済みのユーザー取得
        $user = User::findOrFail($this->ZoomUserID);
        $zoomUser = $this->me();

        // create zoom Meeting
        $url = 'https://api.zoom.us/v2/users/' . $zoomUser->id . '/meetings';
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $user->access_token,
                'Content-Type' => 'application/json',
            ],
        ]);

        // Zoom API アクセス
        $topic = 'test' . rand(1, 2) . '様ご相談';
        $res = $client->request('POST', $url, [
            \GuzzleHttp\RequestOptions::JSON => [
                'topic' => $topic,
                'type' => 2,
                'start_time' => now(),
            ],
        ]);
        $result = json_decode($res->getBody()->getContents());

        // save counseling
        $counseling = Counseling::create([
            'counselor_id' => random_int(1, 3),
            'client_id' => random_int(1, 3),
            'content' => Str::random(30),
            'status' => CounselingStatus::Requesting,
            'counseling_start_at' => $result->start_time,
            'counseling_term' => random_int(10, 15),
            'counseling_url' => $result->start_url,
        ]);

        // view
        return view('sample.api.zoom-create-confirm', [
            'counselingID' => $counseling->id,
            'counselingZoomID' => $result->id,
            'time' => $result->start_time,
            'url' => $counseling->counseling_url,
        ]);
    }

    public function update()
    {
        // Zoom OAuth済みのユーザー取得
        $user = User::findOrFail($this->ZoomUserID);
        $zoomUser = $this->me();

        // get meetings
        $url = 'https://api.zoom.us/v2/users/' . $zoomUser->id . '/meetings';
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $user->access_token,
                'Content-Type' => 'application/json',
            ],
        ]);
        $res = $client->request('GET', $url);
        $result = json_decode($res->getBody()->getContents());
        // pick up first a meeting at random
        $updateMeeting = Arr::first($result->meetings);

        // update zoom Meeting
        $updateUrl = 'https://api.zoom.us/v2/meetings/' . $updateMeeting->id;
        $updateClient = new \GuzzleHttp\Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $user->access_token,
                'Content-Type' => 'application/json',
            ],
        ]);
        // 試験的に1年後に変更
        $newTime = now()->addYear();
        $updateClient->request('PATCH', $updateUrl, [
            \GuzzleHttp\RequestOptions::JSON => [
                'start_time' => $newTime,
            ],
        ]);

        // view
        return view('sample.api.zoom-update-confirm', [
            'MeetingID' => $updateMeeting->id,
            'oldTime' => $updateMeeting->start_time,
            'newTime' => $newTime,
            'url' => $updateMeeting->join_url,
        ]);

    }

    public function delete()
    {
        // Zoom OAuth済みのユーザー取得
        $user = User::findOrFail($this->ZoomUserID);
        $zoomUser = $this->me();

        // get meetings
        $from = now()->format('Y-m-d');
        $to = now()->addCentury()->format('Y-m-d');
        // NOTE: 現在以降のMeeting取得にはfromに加えてto, timezone が必要
        $url = 'https://api.zoom.us/v2/users/' . $zoomUser->id . '/meetings?from=' . $from . '&to=' . $to . '&timezone=Asia/Tokyo';
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $user->access_token,
                'Content-Type' => 'application/json',
            ],
        ]);
        $res = $client->request('GET', $url);
        $result = json_decode($res->getBody()->getContents());

        // pick up first a meeting at random
        $deleteMeeting = Arr::first($result->meetings);

        // delete meeting
        $deleteUrl = 'https://api.zoom.us/v2/meetings/' . $deleteMeeting->id;
        $deleteClient = new \GuzzleHttp\Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $user->access_token,
                'Content-Type' => 'application/json',
            ],
        ]);
        $deleteClient->request('DELETE', $deleteUrl);

        // view
        return view('sample.api.zoom-delete-confirm', [
            'deletedMeetingID' => $deleteMeeting->id,
            'previousMeetingCount' => count($result->meetings),
        ]);
    }

    protected function me()
    {
        // Zoom OAuth済みのユーザー取得
        $checkRefresh = $this->checkRefresh();
        if(! $checkRefresh) {
            throw new \Exception("Refresh Token Error!!!");
        }
        $user = User::findOrFail($this->ZoomUserID);
        $client = new \GuzzleHttp\Client([
            'headers' => ['Authorization' => 'Bearer ' . $user->access_token],
        ]);
        $res = $client->request('GET', 'https://api.zoom.us/v2/users/me');
        $result = json_decode($res->getBody()->getContents());

        return $result;
    }

    protected function checkRefresh()
    {
        $user = User::findOrFail($this->ZoomUserID);
        $token_expires =  new \DateTime($user->zoom_expires_in);
        $now = new \DateTime();

        if($now >= $token_expires) {
            $basic = base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'));
            $client = new \GuzzleHttp\Client([
                'headers' => ['Authorization' => 'Basic ' . $basic],
            ]);
            $res = $client->request('POST', 'https://zoom.us/oauth/token', [
                'query' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $user->refresh_token,
                ],
            ]);
            $result = json_decode($res->getBody()->getContents());

            $user->access_token = $result->access_token;
            $user->refresh_token = $result->refresh_token;
            $unixTime = time();
            $user->zoom_expires_in = date("Y-m-d H:i:s", $unixTime + $result->expires_in);
            $user->save();
            return true;
        }
        return false;
    }
}

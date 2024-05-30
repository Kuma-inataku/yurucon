<?php

namespace App\Http\Controllers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;

class SampleGoogleCloudController extends Controller
{
    public function index()
    {
        // view
        return view('sample.google-cloud.index');
    }

    public function uploadTest()
    {
        // see: https://blog.capilano-fw.com/?p=3359
        $client = new StorageClient();
        // todo: env()をconfig()に変更
        $bucket = $client->bucket(env('GCS_BUCKET_NAME'));
        $bucket->upload(
            fopen(storage_path('test/test.txt'), 'r')
        );

        // view
        return redirect()->route('sample.google-cloud.index')->with('message', 'test.txtをアップロードしました');
    }

    public function uploadDisplay()
    {
        // view
        return view('sample.google-cloud.upload');
    }

    public function upload(Request $request)
    {
        // 画像をローカルへアップロード
        $dir = 'img';
        $path = $request->file('gcs-file')->store('public/' . $dir);

        // GCSへアップロード
        // see: https://blog.capilano-fw.com/?p=3359
        $client = new StorageClient();
        // todo: env()をconfig()に変更
        $bucket = $client->bucket(env('GCS_BUCKET_NAME'));
        // ローカルに保存した画像パスを指定してアップロード
        $imgPath = 'app/' . $path;
        $bucket->upload(
            fopen(storage_path($imgPath), 'r')
        );

        // view
        return redirect()->route('sample.google-cloud.upload-display')->with('message', 'アップロードしました');
    }

    public function show()
    {
        // todo: GCSから画像テストデータ取得

        // view
        return view('sample.google-cloud.show');
    }

    public function delete()
    {
        // todo: GCS内の画像データ削除

        // view
        return redirect()->route('sample.google-cloud.index')->with('message', '画像削除しました');
    }
}

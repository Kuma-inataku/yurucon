<?php

namespace App\Http\Controllers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;

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
        return redirect()->route('sample.google-cloud.index')
            ->with('message', 'test.txtをアップロードしました');
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
        return redirect()->route('sample.google-cloud.upload-display')
            ->with('message', 'アップロードしました');
    }

    /**
     * GCS内の画像データを表示
     * NOTE: 公式Docの「ストリーミングダウンロード」を見ても一度ファイルへダウンロードをする必要があるらしいのでこれに沿って実装
     * @see https://cloud.google.com/storage/docs/streaming-downloads?hl=ja#stream_a_download
     */
    public function show()
    {
        $client = new StorageClient();
        $bucket = $client->bucket(env('GCS_BUCKET_NAME'));
        $imgName = 'lCkvG1TbFwoqITCTxamIRNBGKR7UU28oeY7gYHOe.png';
        $object = $bucket->object($imgName);
        $object->downloadToFile(storage_path('app/public/img/test.png'));

        $imgUrl = $object->signedUrl(now()->addMinutes(5));

        return view('sample.google-cloud.show', [
            'imgUrl' => $imgUrl
        ]);
    }

    public function delete()
    {
        // GCS内の画像データ削除
        $client = new StorageClient();
        $bucket = $client->bucket(env('GCS_BUCKET_NAME'));
        $object = $bucket->object('test.txt');
        $object->delete();

        return redirect()->route('sample.google-cloud.index')
            ->with('message', '画像削除しました');
    }
}

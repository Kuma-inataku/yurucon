<?php

namespace App\Http\Controllers;

use Google\Cloud\Storage\StorageClient;

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
        $bucket = $client->bucket(env('GCS_BUCKET_NAME'));
        $bucket->upload(
            fopen(storage_path('test/test.txt'), 'r')
        );

        // view
        return redirect()->route('sample.google-cloud.index')->with('message', 'test.txtをアップロードしました');
    }
}

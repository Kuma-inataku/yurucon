<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SampleApiController extends Controller
{
    public function index() {
        // @see: https://www.umayadia.com/Note/Note028WebAPISample.htm
        $resp = Http::get('https://reqres.in/api/users?page=2');
        echo "request API done!";
        dd($resp->json());
    }
}

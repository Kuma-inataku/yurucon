<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SampleGoogleCloudController extends Controller
{
    public function index()
    {
        // view
        return view('sample.google-cloud.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZoomSampleController extends Controller
{
    public function auth() {
        // todo: authorize the Zoom API
        return redirect("https://zoom.us/oauth/authorize?response_type=code&client_id=".env("ZOOM_CLIENT_ID")."&redirect_uri=".env("ZOOM_REDIRECT_URI"));
    }

    public function create() {
        // todo: create a new meeting
        
    }

    public function update() {
        // todo: update a new meeting

    }

    public function delete() {
        // todo: delete a new meeting

    }
}

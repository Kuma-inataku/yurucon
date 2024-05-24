<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Class ZoomSampleController
 * @package App\Http\Controllers
 * @see https://developers.zoom.us/docs/integrations/oauth/
 * @see https://jun-app.com/articles/zoom-api-laravel
 */
class ZoomSampleController extends Controller
{
    public function auth() {
        $zoomOAuthLink = 'https://zoom.us/oauth/authorize?'.http_build_query([
            'response_type'=>'code',
            'redirect_uri'=>env('ZOOM_REDIRECT_URI'),
            'client_id'=>env('ZOOM_CLIENT_ID'),
        ]);

        return redirect($zoomOAuthLink);
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

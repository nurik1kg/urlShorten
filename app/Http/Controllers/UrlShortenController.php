<?php

namespace App\Http\Controllers;

use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Models\UrlData;
use App\Models\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class UrlShortenController extends Controller
{
    /**
     * Save url to short.
     */
    public function saveUrl(Request $request)
    {
        $url = $request->get('url');
        if (empty($url)) {
            return response()->json([
                'success' => false,
                'error' => 'url is not null',
            ]);
        }
        return $this->urlCheckToSave($url);
    }

    public function urlCheckToSave($url) {
        $url_data = DB::table('url_data')
            ->where('url', '=', $url)
            ->get();
        if (count($url_data)) {
            return response()->json([
                'success' => true,
                'url' => $url,
                'shorten_url' => $url_data[0]->shorten_url
            ]);
        } else {
            $generator = new UrlGenerator($url);
            $generator->generateUrl();

            $url_data = new UrlData();
            $url_data->url = $url;
            $url_data->shorten_url = URL::to('/').'/'.$generator->getGeneratedUrl();
            $url_data->save();

            return response()->json([
                'success' => true,
                'url' => $url,
                'shorten_url' => $url_data->shorten_url
            ]);
        }
    }

    public function toUrl ($token) {
        $url_data = DB::table('url_data')
            ->where('shorten_url', '=', URL::to('/').'/'.$token)
            ->get();
        if (count($url_data)) {
            return redirect($url_data[0]->url);
        }
        else {
            return response()->json([
                'success' => false,
                'error' => "Not found token",
                'token' => $token
            ]);
        }
    }
}

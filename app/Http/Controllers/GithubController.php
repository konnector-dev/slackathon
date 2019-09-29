<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GithubController extends Controller
{
    public function sendToGithubAuth()
    {
        $url = 'https://github.com/login/oauth/authorize?'
            . 'client_id=' . env('GITHUB_CLIENT_ID')
            //. '&redirect_uri=' . env('GITHUB_REDIRECT_URI')
            . '&redirect_uri=' . url('/github/token-from-code')
            . '&state=' . 'whatislovebabydonthurtme';
        return redirect($url);
    }

    public function setAccessTokenFromCode(Request $request)
    {
        dd($request->all());
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'SOME_URL_HERE' . $method_request);
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($ch);
        curl_close($ch);

        $this->response['response'] = json_decode($output);
    }
}

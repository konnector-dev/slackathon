<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GithubController extends Controller
{
    private $hashBabyHash = 'whatislovebabydonthurtme';
    private $curlGithubUrl = '';
    private $curlGithubToken = '';
    private $curlGithubHeaders = [];

    public function __construct()
    {
        $this->setCurlGithubHeaders('User-Agent: jdecode');
    }

    public function sendToGithubAuth()
    {
        $url = 'https://github.com/login/oauth/authorize?'
            . 'client_id=' . env('GITHUB_CLIENT_ID')
            . '&redirect_uri=' . env('GITHUB_REDIRECT_URI')
            . '&state=' . $this->hashBabyHash;
        return redirect($url);
    }

    public function getAccessTokenFromCode(Request $request)
    {
        $github_return = $request->all();

        if (isset($github_return['code']) && strlen(trim($github_return['code']))) {
            $postvars = [
                'code' => $github_return['code'],
                'client_id' => env('GITHUB_CLIENT_ID'),
                'client_secret' => env('GITHUB_CLIENT_SECRET'),
                'redirect_uri' => env('GITHUB_REDIRECT_URI'),
                'state' => $this->hashBabyHash
            ];
            $url = 'https://github.com/login/oauth/access_token';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);

            $output = curl_exec($ch);
            curl_close($ch);
            return redirect(url('/github/get-user-info?') . $output);
        }

        return $github_return;
    }

    public function getUserInfo(Request $request)
    {
        $rdata = $request->all();
        if (strlen($rdata['access_token'])) {
            $this->curlGithubToken = $rdata['access_token'];
            $this->curlGithubUrl = 'https://api.github.com/user';
            return $this->curlGithub();
        }
    }

    public function getUserInstallations(Request $request)
    {
        $rdata = $request->all();
        if (strlen($rdata['access_token'])) {
            $this->curlGithubToken = $rdata['access_token'];
            $this->curlGithubUrl = 'https://api.github.com/user/installations';
            $this->setCurlGithubHeaders('Accept: application/vnd.github.machine-man-preview+json');
            return $this->curlGithub();
        }
    }

    public function getUserRepos(Request $request)
    {
        $rdata = $request->all();
        if (strlen($rdata['access_token'])) {
            $this->curlGithubToken = $rdata['access_token'];
            $this->curlGithubUrl = 'https://api.github.com/user/repos';
            $this->setCurlGithubHeaders('Accept: application/vnd.github.machine-man-preview+json');
            return $this->curlGithub();
        }
    }

    public function getOwnerRepo(Request $request)
    {
        $rdata = $request->all();
        if (strlen($rdata['access_token'])) {
            $this->curlGithubToken = $rdata['access_token'];
            $this->curlGithubUrl = 'https://api.github.com/repos/konnector-dev/kode';
            $this->setCurlGithubHeaders('Accept: application/vnd.github.machine-man-preview+json');
            return $this->curlGithub();
        }
    }

    public function getRepoPulls(Request $request)
    {
        $rdata = $request->all();
        if (strlen($rdata['access_token'])) {
            $this->curlGithubToken = $rdata['access_token'];
            $this->curlGithubUrl = 'https://api.github.com/repos/konnector-dev/kode/pulls';
            $this->setCurlGithubHeaders('Accept: application/vnd.github.shadow-cat-preview+json');
            return $this->curlGithub();
        }
    }

    public function getCommits(Request $request)
    {
        //
    }

    private function curlGithub()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->curlGithubUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getCurlGithubHeaders());
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    private function setCurlGithubHeaders(String $header)
    {
        $this->curlGithubHeaders[] = $header;
    }

    /**
     * @return Array
     */
    private function getCurlGithubHeaders()
    {
        if (strlen(trim($this->curlGithubToken))) {
            $this->setCurlGithubHeaders('Authorization: Bearer ' . $this->curlGithubToken);
        }
        return $this->curlGithubHeaders;
    }
}

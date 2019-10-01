<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GithubController extends Controller
{
    private $hashBabyHash = 'whatislovebabydonthurtme';
    private $curlGithubUrl = '';
    private $curlGithubToken = '';
    private $curlGithubHeaders = [];
    private $curlGithubPostdata = [];

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
            $this->curlGithubUrl = 'https://github.com/login/oauth/access_token';
            $this->setCurlGithubPost($postvars);
            $output = $this->curlGithub();
            return redirect(url('/github/get-user-info?') . $output);
        }

        return $github_return;
    }

    public function getUserInfo(Request $request)
    {
        $rdata = $request->all();
        if (isset($rdata['access_token']) && strlen($rdata['access_token'])) {
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

    public function setPushHooks(Request $request)
    {
        $rdata = $request->all();
        if (strlen($rdata['access_token'])) {
            $this->curlGithubToken = $rdata['access_token'];
            $this->curlGithubUrl = 'https://api.github.com/repos/konnector-dev/kode/hooks';
            $this->setCurlGithubHeaders('Accept: application/vnd.github.shadow-cat-preview+json');
            $postvars = [
                'name' => 'web',
                'config' => [
                    'url' => 'https://wooks.konnector.dev/post?type=kode-github-qaing',
                    'content_type' => 'json',
                    'insecure_ssl' => 0
                ],
                'events' => [
                    'push',
                    'status',
                    'pull_request_review',
                    'pull_request_review_comment',
                    'pull_request'
                ],
                'active' => true
            ];
            $this->setCurlGithubPost($postvars);
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
        if (count($this->curlGithubPostdata)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->curlGithubPostdata));
        }
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    private function setCurlGithubHeaders(String $header)
    {
        $this->curlGithubHeaders[] = $header;
    }

    private function setCurlGithubPost(array $postvars)
    {
        if (!count($this->curlGithubPostdata)) {
            $this->curlGithubPostdata = $postvars;
            return;
        }
        $this->curlGithubPostdata[] = $postvars;
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

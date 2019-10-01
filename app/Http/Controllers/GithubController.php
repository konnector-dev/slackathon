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
    private $requestData = [];
    private $owner = 'konnector-dev';
    private $repo = 'kode';
    private $isPostJson = false;

    public function __construct()
    {
        $this->setCurlGithubHeaders('User-Agent: jdecode');
    }

    private function accessTokenChecker()
    {
        if (!isset($this->requestData['access_token'])) {
            return ['error' => 'Access token is required'];
        }
        if (strlen($this->requestData['access_token'])) {
            return ['error' => 'Empty access token'];
        }
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
        $this->requestData = $request->all();
        $this->accessTokenChecker($this->requestData);
        $this->curlGithubToken = $this->requestData['access_token'];
        $this->curlGithubUrl = 'https://api.github.com/user';
        return $this->curlGithub();
    }

    public function getUserInstallations(Request $request)
    {
        $this->requestData = $request->all();
        $this->accessTokenChecker($this->requestData);
        $this->curlGithubToken = $this->requestData['access_token'];
        $this->curlGithubUrl = 'https://api.github.com/user/installations';
        $this->setCurlGithubHeaders('Accept: application/vnd.github.machine-man-preview+json');
        return $this->curlGithub();
    }

    public function getUserRepos(Request $request)
    {
        $this->requestData = $request->all();
        $this->accessTokenChecker($this->requestData);
        $this->curlGithubToken = $this->requestData['access_token'];
        $this->curlGithubUrl = 'https://api.github.com/user/repos';
        $this->setCurlGithubHeaders('Accept: application/vnd.github.machine-man-preview+json');
        return $this->curlGithub();
    }

    public function getOwnerRepo(Request $request)
    {
        $this->requestData = $request->all();
        $this->accessTokenChecker($this->requestData);
        $this->curlGithubToken = $this->requestData['access_token'];
        $this->curlGithubUrl = "https://api.github.com/repos/{$this->owner}/{$this->repo}";
        $this->setCurlGithubHeaders('Accept: application/vnd.github.machine-man-preview+json');
        return $this->curlGithub();
    }

    public function getRepoPulls(Request $request)
    {
        $this->requestData = $request->all();
        $this->accessTokenChecker($this->requestData);
        $this->curlGithubToken = $this->requestData['access_token'];
        $this->curlGithubUrl = "https://api.github.com/repos/{$this->owner}/{$this->repo}/pulls";
        $this->setCurlGithubHeaders('Accept: application/vnd.github.shadow-cat-preview+json');
        return $this->curlGithub();
    }

    public function getCommits(Request $request)
    {
        $this->requestData = $request->all();
        $this->accessTokenChecker($this->requestData);
        $this->curlGithubToken = $this->requestData['access_token'];
        $this->curlGithubUrl = "https://api.github.com/repos/{$this->owner}/{$this->repo}/commits";
        return $this->curlGithub();
    }

    public function setPushHooks(Request $request)
    {
        $this->requestData = $request->all();
        $this->accessTokenChecker($this->requestData);
        $this->curlGithubToken = $this->requestData['access_token'];
        $this->curlGithubUrl = "https://api.github.com/repos/{$this->owner}/{$this->repo}/hooks";
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
        $this->isPostJson = true;
        $this->setCurlGithubPost($postvars);
        return $this->curlGithub();
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
            if ($this->isPostJson) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->curlGithubPostdata));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($this->curlGithubPostdata));
            }
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

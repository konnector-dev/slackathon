<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class OauthGithubController extends Controller {

	private $hashBabyHash = 'whatislovebabydonthurtme';
	private $curlGithubUrl = '';
	private $curlGithubToken = '';
	private $curlGithubHeaders = [];
	private $curlGithubPostdata = [];
	private $requestData = [];
	private $owner = 'jdecode';
	private $repo = 'code';
	private $isPostJson = false;
	private $http;
	private $allowedPath = [
		'oauth-github/auth-request',
		'oauth-github/auth'
	];

	public function __construct(Request $request) {
		$this->requestData = $request->all();
		$this->setCurlGithubHeaders('User-Agent: jdecode');
		$this->accessTokenChecker($request->path());
		$this->http = new Client();
	}

	private function accessTokenChecker($path) {
		if (in_array($path, $this->allowedPath)) {
			return;
		}
		if (!isset($this->requestData['access_token'])) {
			$url = (url('/') . '/oauth-github/auth-request');
			return \Redirect::to($url)->send();
		}
		if (!strlen($this->requestData['access_token'])) {
			return ['error' => 'Empty access token'];
		}
		$this->curlGithubToken = $this->requestData['access_token'];
	}

	public function sendToGithubAuth() {
		$url = 'https://github.com/login/oauth/authorize?'
				. 'client_id=' . env('OAUTHAPP_GITHUB_CLIENT_ID')
				. '&redirect_uri=' . env('OAUTHAPP_GITHUB_REDIRECT_URI')
				. '&state=' . $this->hashBabyHash
				. '&scope=' . $this->getScopes();
		return redirect($url);
	}

	private function getScopes() {
		$scopes = [
			'repo:status',
			'repo_deployment',
			'admin:repo_hook',
			'read:org',
			'gist',
			'user:email',
		];
		return implode(' ', $scopes);
	}

	public function getAccessTokenFromCode(Request $request) {
		$github_return = $request->all();
		if (isset($github_return['code']) && strlen(trim($github_return['code']))) {
			$postvars = [
				'code' => $github_return['code'],
				'client_id' => env('OAUTHAPP_GITHUB_CLIENT_ID'),
				'client_secret' => env('OAUTHAPP_GITHUB_CLIENT_SECRET'),
				'redirect_uri' => env('OAUTHAPP_GITHUB_REDIRECT_URI'),
				'state' => $this->hashBabyHash
			];
			$this->curlGithubUrl = 'https://github.com/login/oauth/access_token';
			$this->setCurlGithubPost($postvars);
			return redirect(url('/dashboard?') . $this->getTokenFromParams($this->curlGithub()));
		}
		return $github_return;
	}

	private function getTokenFromParams($params) {
		$_params = explode('&', $params);
		foreach ($_params as $_param) {
			if (stristr($_param, 'access_token=')) {
				return $_param;
			}
		}
		return '';
	}

	public function getUserInfo(Request $request) {
		$this->requestData = $request->all();
		$this->accessTokenChecker($this->requestData);
		$this->curlGithubToken = $this->requestData['access_token'];
		$this->curlGithubUrl = 'https://api.github.com/user';
		return $this->curlGithub();
	}

	public function getUserInstallations(Request $request) {
		$this->requestData = $request->all();
		$this->accessTokenChecker($this->requestData);
		$this->curlGithubToken = $this->requestData['access_token'];
		$this->curlGithubUrl = 'https://api.github.com/user/installations';
		$this->setCurlGithubHeaders('Accept: application/vnd.github.machine-man-preview+json');
		return $this->curlGithub();
	}

	public function getUserRepos(Request $request) {
		return $this->http->request(
						'GET',
						'https://api.github.com/user/repos',
						[
							'headers' => [
								'Authorization' => "Bearer {$this->curlGithubToken}",
								'Accept' => 'application/vnd.github.machine-man-preview+json'
							]
						]
				)->getBody();
	}

	public function getUserOrgs() {
		return $this->http->request(
						'GET',
						'https://api.github.com/user/orgs',
						[
							'headers' => [
								'Authorization' => "Bearer {$this->curlGithubToken}",
								'Accept' => 'application/vnd.github.machine-man-preview+json'
							]
						]
				)->getBody();
	}

	public function getOwnerRepo() {
		return $this->http->request(
						'GET',
						'https://api.github.com/repos/' . ($this->requestData['owner'] ?? $this->owner) . '/' . ($this->requestData['repo'] ?? $this->repo),
						[
							'headers' => [
								'Authorization' => "Bearer {$this->curlGithubToken}",
								'Accept' => 'application/vnd.github.machine-man-preview+json'
							]
						]
				)->getBody();
	}

	public function getOwnerRepos() {
		return $this->http->request(
						'GET',
						'https://api.github.com/orgs/' . ($this->requestData['owner'] ?? $this->owner) . '/repos',
						[
							'headers' => [
								'Authorization' => "Bearer {$this->curlGithubToken}",
								'Accept' => 'application/vnd.github.baptiste-preview+json'
							]
						]
				)->getBody();
	}

	public function getRepoPulls(Request $request) {
		$this->requestData = $request->all();
		$this->accessTokenChecker($this->requestData);
		$this->curlGithubToken = $this->requestData['access_token'];
		$this->curlGithubUrl = "https://api.github.com/repos/{$this->owner}/{$this->repo}/pulls";
		$this->setCurlGithubHeaders('Accept: application/vnd.github.shadow-cat-preview+json');
		return $this->curlGithub();
	}

	public function getCommits() {
		return $this->http->request(
						'GET',
						'https://api.github.com/repos/' . ($this->requestData['owner'] ?? $this->owner) . '/' . ($this->requestData['repo'] ?? $this->repo) . '/commits',
						[
							'headers' => [
								'Authorization' => "Bearer {$this->curlGithubToken}",
							]
						]
				)->getBody();
	}

	public function getSingleCommit() {
		$commit = $this->http->request(
						'GET',
						'https://api.github.com/repos/' . ($this->requestData['owner'] ?? $this->owner) . '/' . ($this->requestData['repo'] ?? $this->repo) . '/commits' . '/' . ($this->requestData['commit-sha'] ?? ''),
						[
							'headers' => [
								'Authorization' => "Bearer {$this->curlGithubToken}"
							]
						]
				)->getBody();
		return $commit;
	}

	public function setPushHooks(Request $request) {
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

	private function curlGithub() {
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

	private function setCurlGithubHeaders(String $header) {
		$this->curlGithubHeaders[] = $header;
	}

	private function setCurlGithubPost(array $postvars) {
		if (!count($this->curlGithubPostdata)) {
			$this->curlGithubPostdata = $postvars;
			return;
		}
		$this->curlGithubPostdata[] = $postvars;
	}

	/**
	 * @return Array
	 */
	private function getCurlGithubHeaders() {
		if (strlen(trim($this->curlGithubToken))) {
			$this->setCurlGithubHeaders('Authorization: Bearer ' . $this->curlGithubToken);
		}
		return $this->curlGithubHeaders;
	}

}

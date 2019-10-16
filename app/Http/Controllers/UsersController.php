<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $request = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function login()
    {
        return response()->view('/login.login', [], 200);
    }

    public function logout()
    {
        return redirect(url('/login'));
    }

    private function userInfo()
    {
        $_user = app('App\Http\Controllers\OauthGithubController')->getUserInfo($this->request);
        return json_decode($_user, true);
    }

    public function dashboard(Request $request)
    {
        $_orgs = app('App\Http\Controllers\OauthGithubController')->getUserOrgs($request);
        $orgs = [];
        $_orgs = json_decode($_orgs, true);
        if (!empty($_orgs) && is_array($_orgs)) {
            foreach ($_orgs as $_org) {
                $orgs[$_org['login']][] = $_org['avatar_url'];
            }
        }
        return view('dark.dashboard', ['orgs' => $orgs, 'user' => $this->userInfo()]);
    }

    public function projects(Request $request)
    {
        $_repos = app('App\Http\Controllers\OauthGithubController')->getOwnerRepos($this->request);
        $repos = [];
        $_repos = json_decode($_repos, true);
        if (!empty($_repos) && is_array($_repos)) {
            foreach ($_repos as $_repo) {
                $repos[$_repo['full_name']] = [
                    'name' => $_repo['name'],
                    'owner' => $_repo['owner']['login'],
                ];
            }
        }
        return view('dark.projects', ['repos' => $repos, 'user' => $this->userInfo()]);
    }

    public function commits()
    {
        $_commits = app('App\Http\Controllers\OauthGithubController')->getCommits($this->request);
        $commits = [];
        $_commits = json_decode($_commits, true);
        if (!empty($_commits) && is_array($_commits)) {
            foreach ($_commits as $_commit) {
                $commits[$_commit['full_name']] = $_commit['name'];
            }
        }
        return view('dark.commits', ['commits' => $commits, 'user' => $this->userInfo()]);
    }
}

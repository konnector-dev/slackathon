<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
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
        $_user = app('App\Http\Controllers\OauthGithubController')->getUserInfo($request);
        $_user = json_decode($_user, true);
        return view('dark.dashboard', ['orgs' => $orgs, 'user' => $_user]);
    }
}

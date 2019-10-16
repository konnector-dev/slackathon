<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'UsersController@login');
Route::get('/logout', 'UsersController@logout');

/**
 * Github App Auth URLs (probably not going to be used)
 */

/*
Route::get('/github/auth-request', 'GithubController@sendToGithubAuth');
Route::get('/github/auth', 'GithubController@getAccessTokenFromCode');
Route::get('/github/get-user-info', 'GithubController@getUserInfo');
Route::get('/github/get-user-installations', 'GithubController@getUserInstallations');
Route::get('/github/get-user-repos', 'GithubController@getUserRepos');
Route::get('/github/get-owner-repo', 'GithubController@getOwnerRepo');
Route::get('/github/get-repo-pulls', 'GithubController@getRepoPulls');
Route::get('/github/set-push-hooks', 'GithubController@setPushHooks');
Route::get('/github/get-commits', 'GithubController@getCommits');
Route::get('/github/get-single-commit', 'GithubController@getSingleCommit');
*/
/**
 * Github OAuth App Auth URLs
 */

Route::get('/oauth-github/auth-request', 'OauthGithubController@sendToGithubAuth');
Route::get('/oauth-github/auth', 'OauthGithubController@getAccessTokenFromCode');
Route::get('/oauth-github/get-user-info', 'OauthGithubController@getUserInfo');
Route::get('/oauth-github/get-user-installations', 'OauthGithubController@getUserInstallations');
Route::get('/oauth-github/get-user-repos', 'OauthGithubController@getUserRepos');
Route::get('/oauth-github/get-user-orgs', 'OauthGithubController@getUserOrgs');
Route::get('/oauth-github/get-owner-repo', 'OauthGithubController@getOwnerRepo');
Route::get('/oauth-github/get-owner-repos', 'OauthGithubController@getOwnerRepos');
Route::get('/oauth-github/get-repo-pulls', 'OauthGithubController@getRepoPulls');
Route::get('/oauth-github/set-push-hooks', 'OauthGithubController@setPushHooks');
Route::get('/oauth-github/get-commits', 'OauthGithubController@getCommits');
Route::get('/oauth-github/get-single-commit', 'OauthGithubController@getSingleCommit');

Route::get('/dashboard', 'UsersController@dashboard');
Route::get('/organizations', 'UsersController@dashboard');
Route::get('/projects', 'UsersController@projects');
Route::get('/commits', 'UsersController@commits');
Route::get('/commit', 'UsersController@commit');

Route::get('/dashboard-bad', 'OauthGithubController@getUserOrgs');

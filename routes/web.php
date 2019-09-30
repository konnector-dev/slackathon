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

Route::get('/github/auth-request', 'GithubController@sendToGithubAuth');
Route::get('/github/auth', 'GithubController@getAccessTokenFromCode');
Route::get('/github/get-user-info', 'GithubController@getUserInfo');
Route::get('/github/get-user-installations', 'GithubController@getUserInstallations');
Route::get('/github/get-user-repos', 'GithubController@getUserRepos');
Route::get('/github/get-owner-repo', 'GithubController@getOwnerRepo');
Route::get('/github/get-repo-pulls', 'GithubController@getRepoPulls');

//Route::get('/github/get-commits', 'GithubController@getCommits');

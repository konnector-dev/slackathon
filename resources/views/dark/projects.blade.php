@extends('layout/reviewee-dark-dashboard')
@section('title', 'Projects')
@section('content')
<?php
$repos_list = '';
foreach ($repos as $repo_owner => $repo_name) {
    $repos_list .= '<li class="repo-projects" style="list-style: none; margin-top: 18px;"><a class="text-white" href="' . url("/commits?owner={$repo_name['owner']}&repo={$repo_name['name']}&access_token=" . app('request')->input('access_token')) . "\">{$repo_name['name']}" . '</a></li>';
}
?>
<ul class="nav flex-column shadow d-flex sidebar mobile-hid" style="background-color: #16181c;">
    <li class="nav-item logo-holder">
        <div class="text-center text-white logo py-4 mx-4">
            <a class="text-white text-decoration-none" id="title"
                title="<?php echo ENV('APP_NAME', 'Koderview') ?>"
                alt="<?php echo ENV('APP_NAME', 'Koderview') ?>"
                href="<?php echo url()->full(); ?>">
                <strong><?php echo ENV('APP_NAME', 'Koderview') ?></strong></a><a
                class="text-white float-right" id="sidebarToggleHolder" href="#"><i class="fas fa-bars"
                    id="sidebarToggle"></i></a></div>
    </li>
    <li class="nav-item">
        <a class="nav-link text-left text-white py-1 px-0"
            href="<?php echo url('/dashboard?access_token=' . app('request')->input('access_token')); ?>">
            <i class="fas fa-tachometer-alt mx-3 fa fa-bar-chart"></i>
            <span class="text-nowrap mx-2">Dashboard</span>
        </a>
    </li>
    <li class="nav-item"><a class="nav-link active text-left text-white py-1 px-0" href="#"><i
                class="fas fa-user mx-3 fa fa-th-list"></i><span class="text-nowrap mx-2">Projects</span></a></li>
    <li class="nav-item"><a class="nav-link text-left text-white py-1 px-0" href="#"><i
                class="far fa-life-ring mx-3"></i><span class="text-nowrap mx-2">Show Off</span></a></li>
    <li class="nav-item"><a class="nav-link text-left text-white py-1 px-0" href="#"><i
                class="fas fa-sign-out-alt mx-3"></i><i class="fa fa-caret-right d-none position-absolute"></i><span
                class="text-nowrap mx-2">Log out</span></a></li>
</ul>
<div class="container-fluid article-clean" style="background-color: #1F2327;font-family: Ubuntu, sans-serif;">
    @include('dark.top-nav')
    <div class="row">
        <div class="col" style="margin: 5px;padding: 0px;">
            <div style="
                    background-color: rgba(0,0,0,0);
                    color: #717E8A;
                    font-size: 18px;
                    border: none;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    text-indent: 1px;
                    text-overflow: '';">
                <div style="padding-left: 3em;"><strong>{{app('request')->input('owner')}}</strong>:</div>
                <ul style="padding-left: 4em;">
                    <?php echo $repos_list; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
    </div>
</div>
@endsection
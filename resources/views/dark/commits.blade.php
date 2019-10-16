@extends('layout/reviewee-dark-dashboard')
@section('title', 'Projects')
@section('content')

<link rel="stylesheet" href="{{  url('/assets/css/Pretty-User-List.css?h=8de3d97f44fc1fd45832f5937b255e4e') }}">

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
                <div style="padding-left: 3em;">
                    <strong>
                    <a 
                        class="text-white"
                        href="<?php
                            echo url('/projects?owner=' . app('request')->input('owner') . '&access_token=' . app('request')->input('access_token'));
                        ?>">
                        {{app('request')->input('owner')}}</a> > 
                        {{app('request')->input('repo')}}</strong>:</div>
            </div>
        </div>
    </div>
    <div class="row">
    </div>
    <div class="row">
        <div class="col">
            <div class="row user-list">
                <?php
                foreach ($commits as $commit) {
                    ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 user-item">
                    <div 
                        class="border rounded border-dark shadow-none user-container" 
                        style="background-color: #212529;">
                        <a 
                            class="user-avatar" 
                            target="_blank" 
                            href="<?php echo $commit['author_url']; ?>">
                            <img 
                                class="rounded-circle img-fluid" 
                                src="<?php echo $commit['author_avatar'] ?>" 
                                width="48" 
                                height="48" 
                                title="<?php echo $commit['author'] ?>"
                                alt="<?php echo $commit['author'] ?>">
                        </a>
                        <p 
                            class="float-sm-left float-md-left float-lg-left float-xl-left user-name">
                            <a 
                                href="<?php echo url('/commit?') . 'owner=' . app('request')->input('owner') . '&repo=' . app('request')->input('repo') . '&commit-sha=' . $commit['sha'] . '&access_token=' . app('request')->input('access_token'); ?>" 
                                style="color: #dbe3e7;"><?php echo $commit['message'] ?>
                            </a>
                            <span title="{{ Carbon\Carbon::parse($commit['time'])->format('F d, Y H:i:s A') }}">
                            <?php echo '<strong>' . $commit['author'] . '</strong> commited ' . Carbon\Carbon::parse($commit['time'])->diffForHumans(); ?>
                            </span>
                        </p>
                        <a 
                            class="btn btn-dark btn-lg text-white-50 bg-dark border rounded border-dark shadow-none float-sm-right float-md-right float-lg-right float-xl-right"
                            role="button" 
                            title="View this on GitHub (opens in new tab/window)" 
                            target="_blank" 
                            style="
                                margin: 11px 0px 0px;
                                background-color: #444f51;
                                color: #dbe3e7;
                                cursor:pointer;" 
                            href="<?php echo $commit['html_url']; ?>"><?php echo substr($commit['sha'], 0, 6) ?>
                        </a>
                        <a 
                            class="btn btn-dark btn-sm text-white-50 bg-dark border rounded border-dark shadow-none float-sm-right float-md-right float-lg-right float-xl-right"
                            role="button" 
                            title="View GitHub JSON (opens in new tab/window)" 
                            target="_blank" 
                            style="
                                margin: 19px 0px 0px;
                                background-color: #444f51;
                                color: #dbe3e7;
                                margin-right: 30%;
                                cursor:pointer;" 
                            href="<?php echo $commit['url']; ?>">Pending
                        </a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
@endsection
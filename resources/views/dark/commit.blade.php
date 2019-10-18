@extends('layout/reviewee-dark-dashboard')
@section('title', 'Projects')
@section('content')

<link rel="stylesheet" href="{{  url('/assets/css/Pretty-User-List.css?h=8de3d97f44fc1fd45832f5937b255e4e') }}">
<link rel="stylesheet" href="{{  url('/assets/css/diff2html.css?h=8de3d97f44fc1fd45832f5937b255e4e') }}">
<link rel="stylesheet" href="{{  url('/assets/css/github.min.css?h=8de3d97f44fc1fd45832f5937b255e4e') }}">

<ul class="nav flex-column shadow d-flex sidebar mobile-hid" style="background-color: #16181c;">
    <li class="nav-item logo-holder">
        <div class="text-center text-white logo py-4 mx-4">
            <a
                class="text-white text-decoration-none" id="title"
                title="<?php echo ENV('APP_NAME', 'Koderview') ?>"
                alt="<?php echo ENV('APP_NAME', 'Koderview') ?>"
                href="<?php echo url()->full(); ?>">
                <strong><?php echo ENV('APP_NAME', 'Koderview') ?></strong>
            </a>
            <a
                class="text-white float-right" id="sidebarToggleHolder" href="#">
                <i class="fas fa-bars" id="sidebarToggle"></i></a></div>
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
            <div
                style="
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
                        <a
                            class="text-white"
                            href="<?php
                            echo url('/commits?owner=' . app('request')->input('owner') . '&repo=' . app('request')->input('repo') . '&access_token=' . app('request')->input('access_token'));
                            ?>">
                            {{app('request')->input('repo')}}</a> >
                        {{ $commit['commit']['message'] }}</strong>:</div>
            </div>
        </div>
    </div>
    <div class="row">
    </div>
    <div class="row">
        <div class="col">
            <div class="row user-list">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 user-item">
                    <div
                        class="border rounded border-dark shadow-none user-container"
                        style="background-color: #212529;">
                        <a
                            class="user-avatar"
                            target="_blank"
                            href="<?php echo $commit['committer']['html_url']; ?>">
                            <img
                                class="rounded-circle img-fluid"
                                src="<?php echo $commit['committer']['avatar_url'] ?>"
                                width="48"
                                height="48"
                                title="<?php echo $commit['commit']['committer']['name'] ?>"
                                alt="<?php echo $commit['commit']['committer']['name'] ?>">
                        </a>
                        <p
                            class="float-sm-left float-md-left float-lg-left float-xl-left user-name">
                            <a
                                href="<?php echo url('/commit?') . 'owner=' . app('request')->input('owner') . '&repo=' . app('request')->input('repo') . '&commit-sha=' . $commit['sha'] . '&access_token=' . app('request')->input('access_token'); ?>"
                                style="color: #dbe3e7;"><?php echo $commit['commit']['message']; ?>
                            </a>
                            <span title="{{ Carbon\Carbon::parse($commit['commit']['committer']['date'])->format('F d, Y H:i:s A') }}">
                                <?php echo '<strong>' . $commit['commit']['committer']['name'] . '</strong> commited ' . Carbon\Carbon::parse($commit['commit']['committer']['date'])->diffForHumans(); ?>
                                <br />
                                <?php echo '<strong>' . count($commit['files']) . '</strong> files' ?>
                                <i
                                    class="badge badge-success text-white commit-stats"
                                    style="display:inline-block;">+<?php echo $commit['stats']['additions'] ?></i>
                                <i
                                    class="badge badge-danger text-white commit-stats"
                                    style="display:inline-block;">-<?php echo $commit['stats']['deletions'] ?></i>
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
                            href="<?php echo $commit['html_url']; ?>"><?php echo substr($commit['sha'], 0, 7) ?>
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
                $file_counter = 1;
                foreach ($commit['files'] as $file) {
                    ?>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 user-item">
                        <div
                            class="border rounded border-dark shadow-none user-container"
                            style="background-color: #212529;">
                            <div class="dark-code-viewer" id="<?php echo 'p-' . $file_counter; ?>">
                                <?php
                                $patch_prefix = "diff --git a/{$file['filename']} b/{$file['filename']}\n"
                                        . "index " . (substr($commit['sha'], 0, 7)) . ".." . (substr($file['sha'], 0, 7)) . " 100644\n"
                                        . "--- a/{$file['filename']}\n"
                                        . "+++ b/{$file['filename']}\n";
                                ?>
                            </div>
                            <script>
                                var diffHtml = Diff2Html.getPrettyHtml(
                                        '<?php echo str_replace("'", "\'", json_encode($patch_prefix . @$file['patch'])); ?>',
                                        {
                                            inputFormat: 'diff',
                                            showFiles: false,
                                            matching: 'lines',
                                            outputFormat: 'line-by-line',
                                            matchingMaxComparisons: 100,
                                            maxLineSizeInBlockForComparison: 100,
                                            maxLineLengthHighlight: 100,
                                        }
                                );
                                document.getElementById("p-<?php echo $file_counter; ?>").innerHTML = diffHtml;
                            </script>
                            <?php $file_counter++; ?>
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
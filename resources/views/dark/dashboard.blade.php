@extends('layout/reviewee-dark-dashboard')
@section('title', 'Dashboard')
@section('content')
<?php
$first = true;
$org_first = '';
$selected = '';
$options = '';
foreach ($orgs as $org_name => $org_avatar) {
    if ($first) {
        $selected = " selected='selected' ";
        $first = false;
        $org_first = $org_name;
    }
    $options .= "<option value='$org_name' $selected>$org_name</option>";
    $selected = '';
}
?>
<ul class="nav flex-column shadow d-flex sidebar mobile-hid" style="background-color: #16181c;">
    <li class="nav-item logo-holder">
        <div class="text-center text-white logo py-4 mx-4"><a class="text-white text-decoration-none" id="title"
                href="#"><strong>Koderview</strong></a><a class="text-white float-right" id="sidebarToggleHolder"
                href="#"><i class="fas fa-bars" id="sidebarToggle"></i></a></div>
    </li>
    <li class="nav-item"><a class="nav-link active text-left text-white py-1 px-0" href="#"><i
                class="fas fa-tachometer-alt mx-3 fa fa-bar-chart"></i><span
                class="text-nowrap mx-2">Dashboard</span></a></li>
    <li class="nav-item"><a class="nav-link text-left text-white py-1 px-0" href="#"><i
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
            <select style="
                    background-color: rgba(0,0,0,0);
                    color: #717E8A;
                    font-size: 18px;
                    border: none;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    text-indent: 1px;
                    text-overflow: '';">
            </select>
        </div>
    </div>
    <div class="row">
    </div>
</div>
@endsection
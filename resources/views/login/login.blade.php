@extends('layout/reviewee-login')
@section('title', 'Login')
@section('content')
<div class="d-flex flex-column justify-content-center" id="login-box">
    <div class="login-box-header">
        <h4 style="color:rgb(139,139,139);margin-bottom:0px;font-weight:400;font-size:27px;">Login</h4>
    </div>
    <div class="login-box-content">
        <div 
            class="fb-login box-shadow"
            style="text-align: center;">
            <a 
                class="d-flex flex-row align-items-center social-login-link" 
                href="{{ secure_url('/oauth-github/auth-request') }}"
                style="
                    width: 50%;
                    text-align: center;
                    margin-left: 25%;
                    background-color: rgb(237,102,63);
                    border-radius: 8px;
                    box-shadow: 1px 5px 10px rgba(0,0,0,0.5);">
                    <i class="fa fa-github" style="margin-left:0px;padding-right:20px;padding-left:22px;width:56px;"></i>
                    &nbsp; Login with GitHub
            </a>
        </div>
        <div class="gp-login box-shadow"></div>
    </div>
    <div id="login-box-footer" style="padding:10px 20px;padding-bottom:23px;padding-top:18px;"></div>
</div>
@endsection
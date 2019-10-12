<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function login() {
        return response()->view('/login/login', [], 200);
    }
}

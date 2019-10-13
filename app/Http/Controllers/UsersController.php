<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function dashboard() {
        $data = ['owners' => [
            'JD',
            'Konnector-dev',
            'uCreateit',
            'test',
        ]];
        return view('dark.dashboard', $data);
    }
}

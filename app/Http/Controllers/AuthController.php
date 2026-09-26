<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(Request $request) {
        return view('index');
    }

    public function login(Request $request) {
        return view('auth.login');
    }

    public function register(Request $request) {
        return view('auth.register');
    }

    public function master(Request $request) {
        return view('master.master');
    }
}

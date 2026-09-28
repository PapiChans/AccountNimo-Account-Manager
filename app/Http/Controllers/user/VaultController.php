<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VaultController extends Controller
{
    public function index(Request $request) {

        $pageName = 'Vault';
        return view('vault.index', compact('pageName'));
    }
}

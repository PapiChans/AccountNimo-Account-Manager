<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vault;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Logs;
use App\Models\Categories;
use App\Models\Account;
use App\Models\AccountLink;

class AccountController extends Controller
{
    public function index(int $category_id) {

        $account = Account::with('category', 'account_link')
        ->where('category_id', $category_id)
        ->orderBy('created_at', 'desc')
        ->get();

        $pageName = 'Accounts';
        $categoryID = $category_id;
        return view('account.index', compact('pageName', 'account', 'categoryID'));
    }
}

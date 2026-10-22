<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Logs;
use App\Models\AccountLink;

class AccountLinkController extends Controller
{
    public function index(Request $request, int $account_id) {
        $pageName = 'Account Link';

        $account = Account::with('account_link')->find($account_id);

        $availableAccounts = Account::where('id', '!=', $account_id)
        ->whereNotIn('id', function ($query) use ($account_id) {
            $query->select('linked_account_id')
                ->from('account_links')
                ->where('account_id', $account_id);
        })
        ->orderBy('name')
        ->get(['id', 'name', 'username']);

        $otherAccount = AccountLink::with('account.category.vault')
        ->where('linked_account_id', $account_id)
        ->get();

        return view('account_link.index', compact('pageName', 'account', 'availableAccounts', 'otherAccount'));
    }
    
    public function store(Request $request) {
        try {
            DB::beginTransaction();

            $accountLink = AccountLink::create([
                'account_id' => $request->account_id,
                'linked_account_id' => $request->linked_account_id,
                'link_type' => $request->link_type,
            ]);

            $linkedAccount = Account::findOrFail($request->linked_account_id);

            Logs::create([
                'user_id' => Auth::user()->id,
                'action' => 'Account Link Created',
                'description' => 'Linked Account: ' . $linkedAccount->name .
                    ' to Account ID: ' . $request->account_id .
                    ' (Type: ' . $request->link_type . ')',
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            $notification = [
                'message' => 'Account link added successfully.',
                'alert_type' => 'success',
                'title' => 'Success',
            ];

            return redirect()
                ->route('account.link.index', ['account_id' => $request->account_id])
                ->with('notification', $notification);
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Internal Server Error.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request, int $account_id, int $link_id)
    {
        try {
            DB::beginTransaction();

            $trash = AccountLink::find($link_id);
            $account_name = $trash->account->name;

            if (!$trash) {
                DB::rollBack();

                return response()->json([
                    'status' => 'error',
                    'text' => 'Account Link not found.',
                ], 200);
            }

            $trash->delete();

            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Account Link Deleted',
                'description' => 'Deleted Account Link from: ' . $account_name,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'text' => 'Account link successfully deleted.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Internal Server Error.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}

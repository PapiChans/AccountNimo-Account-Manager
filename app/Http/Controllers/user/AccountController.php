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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\AccountLink;

class AccountController extends Controller
{
    public function index(int $category_id) {

        $accounts = Account::with('category', 'account_link')
        ->where('category_id', $category_id)
        ->orderBy('created_at', 'desc')
        ->get();

        $vault_id = Categories::find($category_id);

        $pageName = 'Accounts';
        $vaultID = $vault_id->vault_id;
        $categoryID = $category_id;
        return view('account.index', compact('pageName', 'accounts', 'vaultID', 'categoryID'));
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();

            $passwordMask = null;
            $passwordHash = null;

            if ($request->filled('password')) {
                $passwordHash = Hash::make($request->password);
                
                $password = $request->password;
                $length = strlen($password);

                $passwordMask = $length <= 4
                    ? str_repeat('*', $length)
                    : substr($password, 0 ,2)
                        . str_repeat('*', $length - 4)
                        . substr($password, -2);
            }

            $account = Account::create([
                'category_id'   => $request->category_id,
                'name'          => $request->name,
                'username'      => $request->username,
                'password_mask' => $passwordMask,
                'password_hash' => $passwordHash,
                'notes'         => $request->notes,
            ]);

            Logs::create([
                'user_id' => Auth::user()->id,
                'action' => 'Account Added',
                'description' => 'Added Account: '. $account->name,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            $notification = [
                'message' => 'Account added successfully.',
                'alert_type' => 'success',
                'title' => 'Success',
            ];

            return redirect()
                ->route('account.index', ['category_id' => $account->category_id])
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

    public function delete(Request $request, int $account_id) {
        try {
            DB::beginTransaction();

            $delete = Account::with('account_link')->find($account_id);

            $count = $delete->account_link->count();

            if ($count > 0) {
                return response()->json([
                    'status' => 'error',
                    'text' => "There are still links on this account.",
                ], 200);
            }

            Logs::create([
                'user_id' => Auth::user()->id,
                'action' => 'Account Moved to Trash',
                'description' => 'Trashed Account: '. $delete->name,
                'ip_address' => $request->ip(),
            ]);

            $delete->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
            ], 200);
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Internal Server Error.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request) {
        try {
            DB::beginTransaction();

            $account = Account::findOrFail($request->edit_id);

            $oldName = $account->name;
            $oldUsername = $account->username;
            $oldNotes = $account->notes;

            $changes = [];

            if ($oldName !== $request->edit_name) {
                $changes[] = "Account name changed from '{$oldName}' to '{$request->edit_name}'";
            }

            if ($oldUsername !== $request->edit_username) {
                $changes[] = 'Username/email address updated';
            }

            if ($oldNotes !== $request->edit_notes) {
                $changes[] = 'Notes updated';
            }

            $account->name = $request->edit_name;
            $account->username = $request->edit_username;
            $account->notes = $request->edit_notes;

            if ($request->filled('edit_password')) {
                $password = $request->edit_password;
                $length = strlen($password);

                $account->password_hash = Hash::make($password);

                $account->password_mask = $length <= 4
                    ? str_repeat('*', $length)
                    : substr($password, 0, 2)
                        . str_repeat('*', $length - 4)
                        . substr($password, -2);

                $changes[] = 'Password changed';
            }

            if ($account->isDirty()) {
                $account->save();

                if (!empty($changes)) {
                    Logs::create([
                        'user_id' => Auth::id(),
                        'action' => 'Account Updated',
                        'description' => implode('; ', $changes)
                            . " (Account: {$account->name})",
                        'ip_address' => $request->ip(),
                    ]);
                }
            }

            DB::commit();

            $notification = [
                'message' => 'Account updated successfully.',
                'alert_type' => 'success',
                'title' => 'Success',
            ];

            return redirect()
                ->route('account.index', ['category_id' => $account->category_id])
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

    public function verifyPassword(Request $request)
    {
        $validated = $request->validate([
            'verify_account_id' => [
                'required',
                'integer',
                'exists:accounts,id',
            ],
            'verify_password' => [
                'required',
                'string',
            ],
        ]);

        $account = Account::findOrFail($validated['verify_account_id']);

        if (
            empty($account->password_hash) ||
            !Hash::check(
                $validated['verify_password'],
                $account->password_hash
            )
        ) {
            return response()->json([
                'verified' => false,
                'message' => 'The password does not match.',
            ]);
        }

        return response()->json([
            'verified' => true,
            'message' => 'Password verified successfully!',
        ]);
    }
}

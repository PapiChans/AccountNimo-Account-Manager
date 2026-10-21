<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Logs;

class TrashController extends Controller
{
    public function index(Request $request) {
        $pageName = 'Trash';

        $trash = Account::onlyTrashed()
        ->with('category', 'category.vault')
        ->whereHas('category.vault', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })
        ->orderBy('deleted_at', 'desc')
        ->get();

        return view('trash.index', compact('pageName', 'trash'));
    }

    public function bulkDelete(Request $request) {
        try {
            DB::beginTransaction();

            $trash = Account::onlyTrashed()
                ->with('category', 'category.vault')
                ->whereHas('category.vault', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->orderBy('deleted_at', 'desc')
                ->get();

            if ($trash->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'text' => "There are no accounts to be deleted.",
                ], 200);
            }

            foreach ($trash as $account) {
                $account->forceDelete();
            }

            Logs::create([
                'user_id' => Auth::user()->id,
                'action' => 'Clear Trash',
                'description' => 'Clear Trash',
                'ip_address' => $request->ip(),
            ]);

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

    public function restore(Request $request, int $account_id)
    {
        try {
            DB::beginTransaction();

            $restore = Account::onlyTrashed()
                ->whereHas('category.vault', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->find($account_id);

            if (!$restore) {
                DB::rollBack();

                return response()->json([
                    'status' => 'error',
                    'text' => 'Account not found in your trash.',
                ], 200);
            }

            $name = $restore->name;

            $restore->restore();

            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Account Restored',
                'description' => 'Restore Account: ' . $name,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'text' => 'Account restored successfully.',
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

    
    public function delete(Request $request, int $account_id)
    {
        try {
            DB::beginTransaction();

            $trash = Account::onlyTrashed()
                ->whereHas('category.vault', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->find($account_id);

            if (!$trash) {
                DB::rollBack();

                return response()->json([
                    'status' => 'error',
                    'text' => 'Account not found in your trash.',
                ], 200);
            }

            $name = $trash->name;

            $trash->forceDelete();

            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Account Deleted',
                'description' => 'Deleted Account: ' . $name,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'text' => 'Account permanently deleted.',
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

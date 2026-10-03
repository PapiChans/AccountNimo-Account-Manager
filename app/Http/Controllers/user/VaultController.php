<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vault;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Logs;
class VaultController extends Controller
{
    public function index(Request $request) {

        $vault = Vault::with('categories')
        ->where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();

        $pageName = 'Vault';
        return view('vault.index', compact('pageName', 'vault'));
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();

            $vault = Vault::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
            ]);

            Logs::create([
                'user_id' => Auth::user()->id,
                'action' => 'Vault Created',
                'description' => 'Created Vault: '. $vault->name,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            $notification = [
                'message' => 'Vault added successfully.',
                'alert_type' => 'success',
                'title' => 'Success',
            ];

            return redirect()
                ->route('vault.index')
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

    public function update(Request $request) {
        try {
            DB::beginTransaction();

            $vault = Vault::find($request->edit_id);

            $oldName = $vault->name;

            $vault->update([
                'name' => $request->edit_name,
            ]);

            Logs::create([
                'user_id' => Auth::user()->id,
                'action' => 'Vault Updated',
                'description' => 'Updated Vault from: '. $oldName . ' to ' . $request->edit_name,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            $notification = [
                'message' => 'Vault updated successfully.',
                'alert_type' => 'success',
                'title' => 'Success',
            ];

            return redirect()
                ->route('vault.index')
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

    public function delete(Request $request, int $vault_id) {
        try {
            DB::beginTransaction();

            $delete = Vault::with('categories')->find($vault_id);

            $count = $delete->categories->count();

            if ($count > 0) {
                return response()->json([
                    'status' => 'error',
                    'text' => "There are still categories on this vault.",
                ], 200);
            }

            Logs::create([
                'user_id' => Auth::user()->id,
                'action' => 'Vault Deleted',
                'description' => 'Deleted Vault: '. $delete->name,
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
}

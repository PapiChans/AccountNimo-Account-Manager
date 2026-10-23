<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vault;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Logs;

class ProfileController extends Controller
{
    public function index(Request $request) {
        $pageName = 'Profile';

        return view('profile.index', compact('pageName'));
    }

    public function updateName (Request $request) {
        try {

            DB::beginTransaction();

            $account = Auth::user();
            $oldName = $account->name;

            $account->name = $request->name;
            $account->save();

            if($oldName != $request->name) {
                Logs::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Profile Updated',
                    'description' => 'Changed name from ' . $oldName . ' to ' . $request->name,
                    'ip_address' => $request->ip(),
                ]);
            }


            DB::commit();

            $notification = [
                'message' => 'Profile updated successfully.',
                'alert_type' => 'success',
                'title' => 'Success',
            ];

            return redirect()
                ->route('profile.index')
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

    public function checkOldPassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string'],
        ]);

        $account = Auth::user();

        $matches = Hash::check(
            $request->old_password,
            $account->password
        );

        return response()->json($matches);
    }
    
    public function changePassword(Request $request)
    {
        $account = Auth::user();

        if (!Hash::check($request->old_password, $account->password)) {
            return redirect()
                ->route('profile.index')
                ->with('notification', [
                    'message' => 'Your old password is incorrect.',
                    'alert_type' => 'error',
                    'title' => 'Error',
                ]);
        }

        $account->password = Hash::make($request->new_password);
        $account->save();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('notification', [
                'message' => 'Password changed successfully. Please log in with your new password.',
                'alert_type' => 'success',
                'title' => 'Success',
            ]);
    }

}

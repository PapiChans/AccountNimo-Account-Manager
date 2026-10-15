<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vault;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Logs;
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function index(int $vault_id) {

        $categories = Categories::with('vault')
        ->where('vault_id', $vault_id)
        ->orderBy('created_at', 'desc')
        ->get();

        $pageName = 'Categories';
        $vaultID = $vault_id;
        return view('categories.index', compact('pageName', 'categories', 'vaultID'));
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();

            $category = Categories::create([
                'vault_id' => $request->vault_id,
                'name' => $request->name,
                'color' => $request->color,
            ]);

            Logs::create([
                'user_id' => Auth::user()->id,
                'action' => 'Category Created',
                'description' => 'Created Category: '. $category->name,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            $notification = [
                'message' => 'Category added successfully.',
                'alert_type' => 'success',
                'title' => 'Success',
            ];

            return redirect()
                ->route('categories.index' , ['vault_id' => $request->vault_id])
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

            $category = Categories::find($request->edit_id);

            $oldName = $category->name;
            $oldColor = $category->color;

            $category->update([
                'name' => $request->edit_name,
                'color' => $request->edit_color,
            ]);

            if ($oldName != $request->edit_name) {
                Logs::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Category Updated',
                    'description' => 'Category updated from: '. $oldName . ' to ' . $request->edit_name,
                    'ip_address' => $request->ip(),
                ]);
            }

            if ($oldColor != $request->edit_color) {
                Logs::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Category Updated',
                    'description' => 'Category: '. $oldName . ' changed it color. ',
                    'ip_address' => $request->ip(),
                ]);
            }

            DB::commit();

            $notification = [
                'message' => 'Category updated successfully.',
                'alert_type' => 'success',
                'title' => 'Success',
            ];

            return redirect()
                ->route('categories.index', ['vault_id' => $category->vault_id])
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

    public function delete(Request $request, int $category_id) {
        try {
            DB::beginTransaction();

            $delete = Categories::with('accounts')->find($category_id);

            $count = $delete->accounts->count();

            if ($count > 0) {
                return response()->json([
                    'status' => 'error',
                    'text' => "There are still accounts on this category.",
                ], 200);
            }

            Logs::create([
                'user_id' => Auth::user()->id,
                'action' => 'Category Deleted',
                'description' => 'Deleted Category: '. $delete->name,
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

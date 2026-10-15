<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckResourceOwnership
{
    public function handle(
        Request $request,
        Closure $next,
        string $resource,
        string $parameter
    ): Response {
        $userId = Auth::id();

        if (!$userId) {
            return redirect('/login');
        }

        // Read the resource ID from the URL first,
        // then from submitted form data.
        $id = $request->route($parameter)
            ?? $request->input($parameter);

        if (!$id || !$this->ownsResource($resource, $id, $userId)) {
            abort(403, 'Forbidden Access.');
        }

        return $next($request);
    }

    private function ownsResource(
        string $resource,
        mixed $id,
        int|string $userId
    ): bool {
        switch ($resource) {
            case 'vault':
                return DB::table('vaults')
                    ->where('id', $id)
                    ->where('user_id', $userId)
                    ->exists();

            case 'category':
                return DB::table('categories')
                    ->join('vaults', 'categories.vault_id', '=', 'vaults.id')
                    ->where('categories.id', $id)
                    ->where('vaults.user_id', $userId)
                    ->exists();

            case 'account':
                return DB::table('accounts')
                    ->join(
                        'categories',
                        'accounts.category_id',
                        '=',
                        'categories.id'
                    )
                    ->join(
                        'vaults',
                        'categories.vault_id',
                        '=',
                        'vaults.id'
                    )
                    ->where('accounts.id', $id)
                    ->where('vaults.user_id', $userId)
                    ->exists();

            default:
                return false;
        }
    }
}
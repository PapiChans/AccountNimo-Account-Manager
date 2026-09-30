<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logs;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    public function index(Request $request)
    {
        $pageName = 'Logs';

        $query = Logs::where('user_id', Auth::user()->id);

        $monthYear = $request->input('month_year', now()->format('Y-m'));

        try {
            $date = Carbon::createFromFormat('Y-m', $monthYear);

            $query->whereBetween('created_at', [
                $date->copy()->startOfMonth(),
                $date->copy()->endOfMonth(),
            ]);
        } catch (\Exception $e) {
            $monthYear = now()->format('Y-m');

            $date = Carbon::createFromFormat('Y-m', $monthYear);

            $query->whereBetween('created_at', [
                $date->copy()->startOfMonth(),
                $date->copy()->endOfMonth(),
            ]);
        }

        $logs = $query->latest()->get();

        return view('logs.index', compact('pageName', 'logs', 'monthYear'));
    }

}

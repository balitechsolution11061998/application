<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = User::where('id',Auth::user()->id)->update([
                'last_seen_at' => Carbon::now(),
                'active_status' => 1,
            ]);

        }

        return $next($request);
    }

    public function terminate($request, $response)
    {
        if (Auth::check()) {
            $user = User::where('id',Auth::user()->id)->update([
                'last_seen_at' => Carbon::now(),
                'active_status' => 1,
            ]);
        }
    }
}

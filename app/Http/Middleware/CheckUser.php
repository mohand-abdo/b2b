<?php

namespace App\Http\Middleware;

use Log;
use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        $user = Auth::user();


        if ($user) {
        
            $now = Carbon::now();
            $twoWeeksLater = $user->created_at->subweeks(2); 

            if ($now >= $twoWeeksLater && $user->type == 1) {
                Auth::logout();
                return redirect()->route('authrize');
            }
        }
        return $next($request);
    }
}

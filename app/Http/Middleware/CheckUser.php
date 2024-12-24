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

        if ($user)
        {
            $now = Carbon::now();
            $twoWeeksLater = $user->created_at->addWeeks(2); // إضافة أسبوعين بدلاً من خصمهم

            if ($now->gte($twoWeeksLater) && $user->type == 1) {
                // استخدام gte للتحقق من "أكبر من أو يساوي"
                Auth::logout();
                return redirect()->route('authrize');
            }
        }

        return $next($request);
    }
}

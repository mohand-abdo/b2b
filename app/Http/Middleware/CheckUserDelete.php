<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserDelete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // تحقق إذا كان المستخدم مسجل الدخول
        if (Auth::check()) {
            $user = Auth::user();

            // تحقق إذا كان `deleted_at` غير فارغ
            if ($user->deleted_at !== null) {
                // تسجيل خروج المستخدم
                Auth::logout();

                // إعادة المستخدم مع رسالة خطأ
                return redirect()->route('login')->withErrors([
                    'email' => 'حسابك معطل. يرجى مراجعة الإدارة.'
                ]);
            }
        }

        return $next($request);
    }
}

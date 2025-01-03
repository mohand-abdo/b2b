<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
//function to valdition status 
    protected function credentials(Request $request)
    {
        if (is_numeric($request->email)) {
            return ['phone_number' => $request->email, 'password' => $request->password,'status'=>'مفعل'];
        }
       return ['email'=>$request->email, 'password'=>$request->password, 'status'=>'مفعل'];
    }

     // Redirect users based on their roles
     protected function authenticated(Request $request, $user)
     {
         if ($user->roles_name == "agent") {
             return to_route('Clients.index'); // توجيه إلى صفحة العملاء
         }
        elseif($user->roles_name == "user") {
             return to_route('Clients.create'); // توجيه إلى صفحة المستخدم
         }else{
            return to_route('home'); // توجيه إلى صفحة الادمن
         }
 
        //  return to_route('home'); // توجيه إلى الصفحة الرئيسية
     }
}
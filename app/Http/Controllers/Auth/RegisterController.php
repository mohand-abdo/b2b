<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function createUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'numeric', 'digits:10', 'unique:users,phone_number'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'Status' => 'مفعل',
            'roles_name' => 'user',
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        // تسجيل الدخول مباشرة بعد التسجيل (اختياري)
        auth()->login($user);

        // إعادة توجيه المستخدم إلى الصفحة الرئيسية أو أي صفحة أخرى
        return redirect()->route('home')->with('success', 'تم التسجيل بنجاح!');
    }
}

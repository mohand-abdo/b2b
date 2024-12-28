<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Notifications\UserAdded;
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'unique:users,phone_number'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone'],
            'Status' => 'مفعل',
            'roles_name' => 'user',
            'password' => Hash::make($data['password']),
        ]);

        $admins = User::where('roles_name', 'owner')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'title' => 'تم تسجيل مستخدم جديد',
                'message' => "المستخدم {$user->name} قام بالتسجيل في النظام.",
                'url' => 'users.index',
                'user_id' => $admin->id,
                'item_id' => $user->id,
            ]);
        }

        // تعيين الدور للمستخدم الجديد
        $user->assignRole('user');

        // إعادة المستخدم المُنشأ
        return $user;
    }

    protected function register(Request $request)
    {
        // التحقق من صحة البيانات
        $this->validator($request->all())->validate();

        // إنشاء المستخدم
        $user = $this->create($request->all());

        // تسجيل الدخول
        auth()->login($user);

        // إعادة التوجيه
        return redirect()->route('Clients.create')->with('login', 'تم التسجيل بنجاح!');
    }
}

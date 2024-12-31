<?php
namespace App\Http\Controllers;
use App\Mail\InfoAgentRegister;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        // المستخدمين
        // $this->middleware('permission:عرض مستخدم', ['only' => ['index']]);
        $this->middleware('permission:إضافة مستخدم', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل مستخدم', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف مستخدم', ['only' => ['destroy']]);
    }
    public function index(Request $request):View
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);
        if ($request->id !== null) {
            $notfiy = Notification::findOrFail($request->id);
            $notfiy->read = true;
            $notfiy->save();
        }
        return view('users.show_users', compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create():View
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.Add_user', compact('roles'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'phone_number' => 'nullable|numeric|unique:users,phone_number',
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required',
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles_name'));
        if ($user->roles_name == 'agent' && $user->email != '') {
            Mail::to($user->email)->send(new InfoAgentRegister($user)); 
        }
        return redirect()->route('users.index')->with('success', 'تم حفظ المستخدم بنجاح');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id):View
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id):View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'phone_number' => 'required|numeric|unique:users,phone_number,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->update(
            attributes: [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'Status' => $request->Status, // لاحظ أن الحقل يكتب بأحرف صغيرة إذا كان اسم العمود كذلك
                'type' => $request->type, // لاحظ أن الحقل يكتب بأحرف صغيرة إذا كان اسم العمود كذلك
                'roles_name' => $request->roles, // لاحظ أن الحقل يكتب بأحرف صغيرة إذا كان اسم العمود كذلك
            ],
        );

        if ($request->filled('password')) {
            // التحقق مما إذا كانت كلمة المرور مملوءة فقط
            $user->update(['password' => Hash::make($request->password)]);
        }
        // **1. إزالة جميع الأدوار القديمة**
        $user->syncRoles([]);

        if (!empty($request->roles)) {
            $user->assignRole($request->roles);
        }

        // DB::table('model_has_roles')->where('model_id', $id)->delete();
        // $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->user_id;
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }

    public function password_reset(Request $request)
    {
        // التحقق من وجود user_id
        $this->validate(request: $request,rules: [
            'user_id' => 'required|exists:users,id',
        ]);

        $id = $request->user_id;
        $user = User::find($id);

        if ($user) {

            // تعيين كلمة المرور الجديدة
            $user->password = Hash::make(123456789);
            $user->save();

            // يمكنك إضافة إرسال بريد إلكتروني للمستخدم في حال أردت إبلاغه
            // Mail::to($user->email)->send(new PasswordResetMail($newPassword));

            return response()->json(
                [
                    'message' => 'تم إعادة تعيين كلمة المرور بنجاح.',
                ],
                200,
            );
        }

        return response()->json(
            [
                'message' => 'المستخدم غير موجود.',
            ],
            404,
        );
    }

    public function trashed_users():View
    {
        $users = User::onlyTrashed()->get();
        return view('users.trashed',compact('users'));
    }

    public function restore(Request $request):RedirectResponse
    {
        $this->validate(request: $request,rules: [
            'restore_id' =>'required|exists:users,id',
        ]);

        $id = $request->restore_id;
        User::withTrashed()->find( $id)->restore();
        return redirect()->route('users.index')->with('success', 'تم استعادة المستخدم من القائمة المهملة');
    }

    public function force_delete(Request $request):RedirectResponse
    {
        $this->validate(request: $request,rules: [
            'force_delete_id' =>'required|exists:users,id',
        ]);

        $id = $request->force_delete_id;
        User::withTrashed()->find( $id)->forceDelete();
        return redirect()->route('users.trashed_users')->with('success', 'تم حذف المستخدم نهائيا ');
    }
}

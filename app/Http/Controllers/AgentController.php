<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Mail\InfoAgentRegister;
use Illuminate\Validation\Rule;
use App\Mail\AgentAddClientEmail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        // استرجاع جميع المستخدمين الذين لديهم دور 'agent'
        $agents = User::where('roles_name', 'agent')->get();

        // إرسال البيانات إلى العرض
        return view('agent.index', compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name');
        return view('agent.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate(
            request: $request,
            rules: [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'required|numeric|unique:users,phone_number',
                'password' => 'required|same:confirm-password',
            ],
        );
        $user = User::create(
            attributes: [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'Status' => $request->Status,
                'roles_name' => 'agent',
                'password' => Hash::make($request->password),
            ],
        );

        $user->assignRole('agent');

        if ($user->roles_name == 'agent' && $user->email != '') {
            Mail::to($user->email)->send(new InfoAgentRegister($user));
        }
        return redirect()->route('agent.index')->with('success', 'تم حفظ الوكيل بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $agent): View
    {
        return view('agent.edit', compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, User $agent): RedirectResponse
    {
        $this->validate(
            request: $request,
            rules: [
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($agent->id, 'id'), // استثناء المستخدم الحالي حسب معرفه (id)
                ],
                'phone_number' => [
                    'required',
                    'numeric',
                    Rule::unique('users', 'phone_number')->ignore($agent->id, 'id'), // نفس المنطق لرقم الهاتف
                ],
                'password' => 'nullable|same:confirm-password', // كلمة المرور اختيارية مع التحقق من التطابق
            ],
        );

        $agent->update(
            attributes: [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'Status' => $request->Status, // لاحظ أن الحقل يكتب بأحرف صغيرة إذا كان اسم العمود كذلك
            ],
        );

        if ($request->filled('password')) {
            // التحقق مما إذا كانت كلمة المرور مملوءة فقط
            $agent->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('agent.index')->with('edit', 'تم حفظ البيانات بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $agent): RedirectResponse
    {
        $agent->delete();
        return redirect()->route('agent.index')->with('delete', 'تم حذف الوكيل بنجا��.');
    }
}

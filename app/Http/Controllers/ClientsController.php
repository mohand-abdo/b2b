<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Tree3;
use App\Models\Tree4;
use App\Models\Operation;
use Illuminate\View\View;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Mail\AgentAddClientEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Client\StoreClientRequest;
use Illuminate\Http\RedirectResponse;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $tree4s = Tree4::where('tree3_code', 1205)->where('status', 1);

        if ($user->roles_name == 'owner') {
            // لا حاجة لاستخدام get() هنا، لأنها مجموعة بيانات بالفعل
            $tree4s = $tree4s->get(); // عرض جميع البيانات
        } elseif ($user->roles_name == 'agent') {
            $tree4s = $tree4s->where('user_id', $user->id)->get(); // عرض البيانات التي أضافها المستخدم فقط
        }

        if ($request->id !== null) {
            $notfiy = Notification::findOrFail($request->id);
            $notfiy->read = true;
            $notfiy->save();
        }

        $tree3s = Tree3::all();

        return view('clients.Clients', compact('tree3s', 'tree4s'));
    }

    public function inactive(Request $request)
    {
        $user = auth()->user();
        $tree4s = Tree4::where('tree3_code', 1205)->where('status', 0);

        if ($user->roles_name == 'owner') {
            $tree4s = $tree4s->get(); // عرض جميع البيانات
        } elseif ($user->roles_name == 'agent') {
            $tree4s = $tree4s->where('user_id', $user->id)->get(); // عرض البيانات التي أضافها المستخدم فقط
        }

        $tree3s = Tree3::all();

        if ($request->id !== null) {
            $notfiy = Notification::findOrFail($request->id);
            $notfiy->read = true;
            $notfiy->save();
        }
        return view('clients.inactive', compact('tree3s', 'tree4s'));
    }

    public function create(Request $request): View
    {
        if ($request->id !== null) {
            $notfiy = Notification::findOrFail($request->id);
            $notfiy->read = true;
            $notfiy->save();
        }
        return view('clients.create');
    }

    public function search(): View
    {
        return view('clients.index');
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        try {
            if (Auth::user()->roles_name == 'user') {
                $check_user = Tree4::where('user_id', Auth::id())->exists();
                if ($check_user) {
                    return redirect()->back()->with('error', 'عفوا، لا يمكنك اضافة عميل جديد حيث أنك تمتلك مستخدم أخر.');
                }
            }

            // Begin transaction
            DB::beginTransaction();

            // Create a new Tree4 entry
            $tree4 = new Tree4();
            $tree4->tree4_name = $request->tree4_name;
            $tree4->tree3_code = 12;
            $tree4->iden = $request->iden;
            $tree4->phone = $request->phone;
            $tree4->email = $request->email;
            $tree4->location = $request->location;
            $tree4->nationalty = $request->nationalty;

            // Handle file upload (if exists)
            if ($request->hasFile('file')) {
                $tree4->file = $request->file('file')->store('files', 'public'); // أو أي مسار آخر حسب الإعدادات
            }

            // Check role and set status
            if (Auth::user()->roles_name != 'owner') {
                $tree4->status = 0;
            } else {
                $tree4->status = 1;
            }

            // Set other fields
            $tree4->type = $request->type;
            $tree4->user_id = Auth::user()->id;

            // Generate tree4_code
            $check = Tree4::where('tree3_code', 1205)->orderBy('id', 'DESC')->first();
            if ($check) {
                $tree4->tree4_code = $check->tree4_code + 1;
            } else {
                $tree4->tree4_code = $tree4->tree3_code * 100000 + 1;
            }

            // Save Tree4 entry
            $tree4->save();

            if (Auth::user()->roles_name == 'agent') {
                foreach (User::where('roles_name', 'owner')->get() as $admin) {
                    // حفظ الإشعار في قاعدة البيانات
                    Notification::create([
                        'user_id' => $admin->id,
                        'title' => 'ادخال ' . $request->type,
                        'url' => 'Clients.inactive',
                        'item_id' => $tree4->id,
                        'message' => 'الوكيل ' . Auth::user()->name . ' قام بإدخال ' . $request->type . ' جديد.',
                    ]);
                }
            }

            if (Auth::user()->roles_name == 'user') {
                foreach (User::where('roles_name', 'owner')->get() as $admin) {
                    Notification::create([
                        'user_id' => $admin->id,
                        'title' => 'ادخال ' . $request->type,
                        'url' => 'Clients.inactive',
                        'item_id' => $tree4->id,
                        'message' => 'لقد قام  ' . Auth::user()->name . 'بادخال بياناته ك' . $request->type,
                    ]);
                }
            }

            // if (Auth::user()->roles_name == 'agent') {
            //     Mail::to('mohand10959@gmail.com')->send(new AgentAddClientEmail($tree4, Auth::user()->name));
            // }

            // Commit transaction
            DB::commit();

            // Flash success message
            Session()->flash('success', 'تمت إضافة الحاج بنجاح');

            // Return based on user role
            if (Auth::user()->roles_name == 'user') {
                return back()->with('success', 'تم إدخال البيانات بنجاح');
            }
            return redirect()->route('Clients.index');
        } catch (\Exception $e) {
            // Rollback transaction if any exception occurs
            DB::rollback();

            // Log the error (optional)
            // \Log::error($e->getMessage());

            // Handle the exception and return error message
            return back()
                ->withErrors(['error' => 'حدث خطأ أثناء إضافة البيانات. يرجى المحاولة مرة أخرى.'])
                ->withInput();
        }
    }

    public function show(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $name = $request->tree4;
        $Madin = Operation::where('Madin', $request->tree4)
            ->whereDate('created_at', '>=', $request->start)
            ->whereDate('created_at', '<=', $request->end)
            ->orderBy('id', 'DESC')
            ->get();
        $Dain = Operation::where('Dain', $request->tree4)
            ->whereDate('created_at', '>=', $request->start)
            ->whereDate('created_at', '<=', $request->end)
            ->orderBy('id', 'DESC')
            ->get();

        $id = 1;

        return view('clients.show', compact('Madin', 'Dain', 'start', 'end', 'name', 'id'));
    }

    public function update(Request $request)
    {
        // Validate the form data
        $request->validate(
            [
                'id' => 'required|exists:tree4s,id',
                'tree4_name' => 'required|unique:tree4s,tree4_name,' . $request->id,
                'iden' => 'required|unique:tree4s,iden,' . $request->id,
                'phone' => 'required',
                'type' => 'required',
                'email' => 'required|email|unique:tree4s,email,' . $request->id,
            ],
            [
                'id.required' => 'معرف الحاج مطلوب.',
                'id.exists' => 'الحاج المحدد غير موجود.',
                'tree4_name.required' => 'اسم الحاج مطلوب.',
                'tree4_name.unique' => 'اسم الحاج مستخدم بالفعل.',
                'iden.required' => 'رقم الهوية مطلوب.',
                'iden.unique' => 'رقم الهوية مستخدم بالفعل.',
                'phone.required' => 'رقم الهاتف مطلوب.',
                'email.required' => 'البريد الإلكتروني مطلوب.',
                'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
                'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
                'type.required' => 'النوع مطلوب.',
            ],
        );

        // Find the Tree4 entry
        $tree4 = Tree4::find($request->id);
        $tree4->tree4_name = $request->tree4_name;
        $tree4->iden = $request->iden;
        $tree4->phone = $request->phone;
        $tree4->email = $request->email;
        $tree4->location = $request->location;
        $tree4->nationalty = $request->nationalty;
        $tree4->file = $request->file; // Assuming file is optional or handled separately
        $tree4->type = $request->type;
        $tree4->user_id = Auth::user()->id;
        $tree4->save();

        Session()->flash('edit', 'تمت تحديث بيانات الحاج بنجاح');

        return redirect()->route('Clients.index');
    }

    public function destroy(Request $request)
    {
        $request->validate(
            rules: [
                'id' => ['required', 'exists:tree4s,id'],
                [
                    'id.required' => 'معرف الحاج مطلوب.',
                    'id.exists' => 'الحاج المحدد غير موجود.',
                ],
            ],
        );
        $id = $request->id;
        Tree4::find($id)->delete();
        session()->flash('delete');

        return redirect()->route('Clients.index');
    }

    public function toggleStatus($id)
    {
        $tree4 = Tree4::findOrFail($id);
        $tree4->status = !$tree4->status;
        $tree4->save();

        $agent = $tree4->user;
        if ($agent->roles_name == 'agent') {
            Notification::create([
                'title' => 'تقعيل ' . $tree4->type,
                'message' => 'لقد قام الادمن ' . Auth::user()->name . ' بتفعيل ' . $tree4->type . ' ' . $tree4->tree4_name . ' يرجى متابعة بقية الاحراءات له',
                'url' => 'Clients.index',
                'user_id' => $agent->id,
                'item_id' => $tree4->id,
            ]);
        } elseif ($agent->roles_name == 'user') {
            Notification::create([
                'title' => 'تقعيل ' . $tree4->type,
                'message' => 'لقد قام الادمن ' . Auth::user()->name . ' بتفعيل بياناتك ',
                'url' => 'Clients.create',
                'user_id' => $agent->id,
                'item_id' => $tree4->id,
            ]);
        }

        return response()->json(['status' => $tree4->status]);
    }

    public function show_pic()
    {
        if (Auth::user()->roles_name == 'agent') {
            $tree4Id = Tree4::select('id')->where('user_id', Auth::id())->get();
            if ($tree4Id->count() > 0) {
                $files = File::with('tree4')
                    ->where('tree4_id', $tree4Id[0]->id)
                    ->get();
            } else {
                $files = File::query();
            }
        } else {
            $tree4Id = Tree4::where('user_id', Auth::id())->pluck('id')->first();
            $files = File::where('tree4_id', $tree4Id)->get();
        }
        return view('clients.show_pic', compact('files', 'tree4Id'));
    }

    public function my_statment()
    {
        $tree4_code = Tree4::where('user_id', Auth::id())->pluck('tree4_code')->first();
        $Madin = Operation::where('Madin', $tree4_code)->orderBy('id', 'DESC')->get();
        $Dain = Operation::where('Dain', $tree4_code)->orderBy('id', 'DESC')->get();
        return view('clients.my_statment', compact('Madin', 'Dain'));
    }

    public function getStatement(Request $request)
    {
        $search = $request->get('q');
        if ($search != '') {
            $query = Tree4::query()
                ->where('tree3_code', 1205)
                ->where('status', 1)
                ->when($search, function ($query) use ($search) {
                    $query->where('tree4_name', 'like', '%' . $search . '%');
                });

            if (Auth::user()->roles_name == 'owner') {
                // لا حاجة لاستخدام get() هنا، لأنها مجموعة بيانات بالفعل
                $tree4 = $query->get(); // عرض جميع البيانات
            } elseif (Auth::user()->roles_name == 'agent') {
                $tree4 = $query->where('user_id', Auth::id())->get(); // عرض البيانات التي أضافها المستخدم فقط
            }

            $formattedResults = $tree4->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->tree4_name, // الحقل الذي سيظهر في Select2
                ];
            });

            return response()->json($formattedResults);
        }
    }
}

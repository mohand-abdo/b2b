<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Tree3;
use App\Models\Tree4;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Client\StoreClientRequest;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $tree4s = Tree4::where('tree3_code', 1205)->where('status', 1)->get();

        if ($user->roles_name == 'owner') {
            $tree4s = $tree4s->get(); // عرض جميع البيانات
        } elseif ($user->roles_name == 'agent') {
            $tree4s = $tree4s->where('user_id', $user->id)->get(); // عرض البيانات التي أضافها المستخدم فقط
        }

        $tree3s = Tree3::all();
        $id = 1;

        return view('clients.Clients', compact('tree3s', 'tree4s', 'id'));
    }

    public function inactive()
    {
        $user = auth()->user();
        $tree4s = Tree4::where('tree3_code', 1205)->where('status', 0);

        if ($user->roles_name == 'owner') {
            $tree4s = $tree4s->get(); // عرض جميع البيانات
        } elseif ($user->roles_name == 'agent') {
            $tree4s = $tree4s->where('user_id', $user->id)->get(); // عرض البيانات التي أضافها المستخدم فقط
        }

        $tree3s = Tree3::all();
        return view('clients.inactive', compact('tree3s', 'tree4s'));
    }

    public function create()
    {
        return view('clients.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $tree4s = Tree4::where('tree3_code', 1205)->where('status', 1)->get();

        return view('clients.index', compact('tree4s'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        try {
            // Begin transaction
            DB::beginTransaction();

            // Create a new Tree4 entry
            $tree4 = new Tree4();
            $tree4->tree4_name = $request->tree4_name;
            $tree4->tree3_code = 1205;
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
            if (Auth::user()->roles_name == 'user') {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $name = $request->tree4;
        $Madin = Operation::where('Madin', $request->tree4)
            ->whereDate('date', '>=', $request->start)
            ->whereDate('date', '<=', $request->end)
            ->orderBy('id', 'DESC')
            ->get();
        $Dain = Operation::where('Dain', $request->tree4)
            ->whereDate('date', '>=', $request->start)
            ->whereDate('date', '<=', $request->end)
            ->orderBy('id', 'DESC')
            ->get();

        $id = 1;

        return view('clients.show', compact('Madin', 'Dain', 'start', 'end', 'name', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
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

        return response()->json(['status' => $tree4->status]);
    }

    public function show_pic()
    {
        $tree4Id = Tree4::where('user_id', Auth::id())->pluck('id')->first();
        $files = File::where('tree4_id', $tree4Id)->get();
        return view('clients.show_pic', compact('files', 'tree4Id'));
    }

    public function my_statment()
    {
        $tree4_code = Tree4::where('user_id', Auth::id())->pluck('tree4_code')->first();
        $Madin = Operation::where('Madin', $tree4_code)->orderBy('id', 'DESC')->get();
        $Dain = Operation::where('Dain', $tree4_code)->orderBy('id', 'DESC')->get();
        return view('clients.my_statment', compact('Madin','Dain'));
    }
}

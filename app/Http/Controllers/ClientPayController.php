<?php

namespace App\Http\Controllers;

use App\Models\Plus;
use App\Models\User;
use App\Models\Tree4;
use App\Models\Operation;
use App\Models\Notification;
use App\Models\Restrictions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClientPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $daily = Operation::where('type', 8)->orderBy('created_at', 'desc');
        if (Auth::user()->roles_name == 'owner') {
            $daily = $daily->get();
            if ($request->id !== null) {
                $notfiy = Notification::findOrFail($request->id);
                $notfiy->read = true;
                $notfiy->save();
            }
        } elseif (Auth::user()->roles_name == 'agent') {
            $daily = $daily->where('user_id', Auth::id())->get();
        }
        $id = 1;
        return view('clients.client_pay', compact('daily', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): View|RedirectResponse
    {
        $Madin = $request->Madin;
        $Dain = $request->Dain;
        $check = Plus::where('campaign_id', $request->campaign)
            ->where(function ($query) use ($Madin, $Dain) {
                $query
                    ->where('tree4_code', $Madin) // المدين يساوي القيمة
                    ->orWhere('tree4_code', $Dain); // أو الدائن يساوي القيمة
            })
            ->exists();
        if (!$check) {
            return back()->with('error', 'هناك خطأ ما!');
        }
        $this->validate($request, [
            'Madin' => 'required',
            'Dain' => 'required',
            'price' => 'required',
            'date' => 'required',
            'campaign' => 'required',
        ]);
        $pluseId = Plus::orWhere('tree4_code', $request->Madin)
            ->orWhere('tree4_code', $request->Dain)
            ->where('campaign_id', $request->campaign)
            ->first();
        // $check =   $request->Constraint_number;
        $operation = new Operation();
        $operation->Dain = $request->Dain;
        $operation->Madin = $request->Madin;
        $operation->price = $request->price;
        $operation->date = $request->date;
        $operation->plus_id = $pluseId == '' ? null : $pluseId->id;
        $operation->Statement = $request->Statement;
        $operation->Constraint_number = $request->Constraint_number;
        $operation->type = 8;
        $operation->user_id = Auth::user()->id;
        $operation->save();

        $op_id = Operation::latest()->first()->id;
        $daily = new Restrictions();
        $daily->tree4_code = $request->Dain;
        $daily->Dain = $request->price;
        $daily->Madin = 0;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
        $daily->op_id = $op_id;
        $daily->Constraint_number = $request->Constraint_number;
        $daily->type = 8;
        $daily->user_id = Auth::user()->id;
        $daily->save();

        $op_id = Operation::latest()->first()->id;
        $daily = new Restrictions();
        $daily->tree4_code = $request->Madin;
        $daily->Dain = 0;
        $daily->Madin = $request->price;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
        $daily->op_id = $op_id;
        $daily->Constraint_number = $request->Constraint_number;
        $daily->type = 8;
        $daily->user_id = Auth::user()->id;
        $daily->save();

        if (Auth::user()->roles_name == 'agent') {
            foreach (User::where('roles_name', 'owner')->get() as $admin) {
                // حفظ الإشعار في قاعدة البيانات
                Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'دفعية جديدة',
                    'url' => 'ClientPay.index',
                    'message' => 'قام الوكيل  ' . Auth::user()->name . ' بدفعة مالية مقدارها ' . $request->price . ' في الحساب  ' . $operation->Madins->tree4_name,
                ]);
            }
        }

        Session()->flash('success');

        return redirect()->route('ClientPay.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = Operation::find($id);
        $numberToWords = new NumberToWords();

        // build a new number transformer using the RFC 3066 language identifier
        $numberTransformer = $numberToWords->getNumberTransformer('ar');
        return view('clients.bill', compact('bill', 'numberTransformer'));
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        // $sections=sections::find($id);
        // $sections->delete();
        Operation::find($id)->delete();
        session()->flash('delete');
        return redirect('/ClientPay');
    }

    public function getSelect(Request $request)
    {
        $search = $request->get('q'); // النص المدخل من المستخدم
        $exclude = $request->get('exclude', null);

        // بدء الاستعلام الأساسي
        if ($search != null) {
            $query = Tree4::query();

            // الشرط الأساسي للحالة العامة
            $query->where('status', '1')->where(function ($q) {
                $q->whereIn('tree3_code', ['1202', '1203']);
            });

            // استثناء الحساب المختار في "من حساب" إذا وجد
            if (!empty($exclude)) {
                $query->where('id', '!=', $exclude);
            }

            // البحث بالنص المدخل
            if (!empty($search)) {
                $query->where('tree4_name', 'like', '%' . $search . '%');
            }

            // إذا كان المستخدم "owner" أو "agent"، معالجة الكود 1205 بناءً على نص البحث
            if (!empty($search)) {
                if (Auth::user()->roles_name == 'owner') {
                    // جلب السجلات التي تحتوي على الكود 1205 فقط عند التطابق مع نص البحث
                    $query->orWhere(function ($q) use ($search) {
                        $q->where('tree3_code', '1205')->where('tree4_name', 'like', '%' . $search . '%');
                    });
                } elseif (Auth::user()->roles_name == 'agent') {
                    // إضافة شرط user_id عند البحث بالكود 1205 للوكيل
                    $query->orWhere(function ($q) use ($search) {
                        $q->where('tree3_code', '1205')
                            ->where('tree4_name', 'like', '%' . $search . '%')
                            ->where('user_id', Auth::id());
                    });
                }
            }

            // استثناء الحساب المختار في "من حساب" إذا وجد
            if (!empty($exclude)) {
                $query->where('id', '!=', $exclude);
            }

            // تنفيذ الاستعلام وجلب النتائج
            $tree4 = $query->get();

            // تنسيق النتائج لـ Select2
            $formattedResults = $tree4->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->tree4_name, // الحقل الذي سيظهر في Select2
                ];
            });

            return response()->json($formattedResults);
        }
    }

    public function getSelectCode(Request $request)
    {
        $search = $request->get('q'); // النص المدخل من المستخدم
        $exclude = $request->get('exclude', null);

        // بدء الاستعلام الأساسي
        if ($search != null) {
            $query = Tree4::query();

            // الشرط الأساسي للحالة العامة
            $query->where('status', '1')->where(function ($q) {
                $q->whereIn('tree3_code', ['1202', '1203']);
            });

            // استثناء الحساب المختار في "من حساب" إذا وجد
            if (!empty($exclude)) {
                $query->where('tree4_code', '!=', $exclude);
            }

            // البحث بالنص المدخل
            if (!empty($search)) {
                $query->where('tree4_name', 'like', '%' . $search . '%');
            }

            // إذا كان المستخدم "owner" أو "agent"، معالجة الكود 1205 بناءً على نص البحث
            if (!empty($search)) {
                if (Auth::user()->roles_name == 'owner') {
                    // جلب السجلات التي تحتوي على الكود 1205 فقط عند التطابق مع نص البحث
                    $query->orWhere(function ($q) use ($search) {
                        $q->where('status', '1')
                            ->where('tree3_code', '1205')
                            ->where('tree4_name', 'like', '%' . $search . '%');
                    });
                } elseif (Auth::user()->roles_name == 'agent') {
                    // إضافة شرط user_id عند البحث بالكود 1205 للوكيل
                    $query->orWhere(function ($q) use ($search) {
                        $q->where('status', '1')
                            ->where('tree3_code', '1205')
                            ->where('tree4_name', 'like', '%' . $search . '%')
                            ->where('user_id', Auth::id());
                    });
                }
            }

            // استثناء الحساب المختار في "من حساب" إذا وجد
            if (!empty($exclude)) {
                $query->where('tree4_code', '!=', $exclude);
            }

            // تنفيذ الاستعلام وجلب النتائج
            $tree4 = $query->get();

            // تنسيق النتائج لـ Select2
            $formattedResults = $tree4->map(function ($item) {
                return [
                    'id' => $item->tree4_code,
                    'text' => $item->tree4_name, // الحقل الذي سيظهر في Select2
                ];
            });

            return response()->json($formattedResults);
        }
    }
}

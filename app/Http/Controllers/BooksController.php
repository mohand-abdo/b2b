<?php

namespace App\Http\Controllers;

use App\Models\Tree3;
use App\Models\Tree4;
use Illuminate\View\View;
use App\Models\Restrictions;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():View
    {
        // $tree3s = Tree3::all();
        return view('books.index');
    }

    public function show(Request $request):View
    {
        $number = $request->tree3;
        $tree4ID = Tree4::where('tree3_code', $number)->pluck('id');
        $one = Restrictions::whereIn('tree4_code', $tree4ID )
            ->whereDate('date', '>=', $request->start)
            ->whereDate('date', '<=', $request->end)
            ->get();
        $Madin = Restrictions::whereIn('tree4_code', $tree4ID )
            ->whereDate('date', '>=', $request->start)
            ->whereDate('date', '<=', $request->end)
            ->sum('Madin');
        $Dain = Restrictions::whereIn('tree4_code', $tree4ID )
            ->whereDate('date', '>=', $request->start)
            ->whereDate('date', '<=', $request->end)
            ->sum('Dain');
        $start = $request->start;
        $end = $request->end;
        return view('books.show', compact('one', 'start', 'end', 'Madin', 'Dain'));
    }

    public function getBook(Request $request)
    {
        $search = $request->get('q'); // النص المدخل من المستخدم
        $exclude = $request->get('exclude', null);

        // بدء الاستعلام الأساسي
        if ($search != null) {
            $query = Tree3::query();

            // البحث بالنص المدخل
            if (!empty($search)) {
                $query->where('tree3_name', 'like', '%' . $search . '%');
            }

            // استثناء الحساب المختار في "من حساب" إذا وجد
            if (!empty($exclude)) {
                $query->where('id', '!=', $exclude);
            }

            // تنفيذ الاستعلام وجلب النتائج
            $tree3 = $query->get();

            // تنسيق النتائج لـ Select2
            $formattedResults = $tree3->map(function ($item) {
                return [
                    'id' => $item->tree3_code,
                    'text' => $item->tree3_name, // الحقل الذي سيظهر في Select2
                ];
            });

            return response()->json($formattedResults);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Plus;
use App\Models\Stage;
use App\Models\Tree4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlusController extends Controller
{
    public function index()
    {
        $pluses = Plus::with('stage')->get();
        // Assuming tree4 is coming from the stages
        return view('plus.index', compact('pluses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tree4_id' => 'required',
            'stage_id' => 'required|exists:stages,id',
            'campaign_id' => 'required',
        ]);

        // Check if the tree4_code already exists for the given stage_id
        $exists = Plus::where('stage_id', $request->stage_id)
            ->where('tree4_id', $request->tree4_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'هذا الحاج موجود بالفعل في هذه المرحلة.');
        }

        // Create new Plus record
        $plus = Plus::create([
            'stage_id' => $request->stage_id,
            'tree4_id' => $request->tree4_id,
            'campaign_id' => $request->campaign_id,
        ]);

        $plus->tree4_code = $plus->tree4->tree4_code;
        $plus->save();

        return redirect()->back()->with('success', 'تم إضافة الحاج بنجاح.');
    }

    public function destroy(Request $request)
    {
        $request->validate(
            rules: [
                'id' => ['required', 'exists:pluses,id'],
                [
                    'id.required' => 'معرف المرحلة مطلوب.',
                    'id.exists' => 'المرحلة المحددة غير موجودة.',
                ],
            ],
        );
        $plus = Plus::findOrFail($request->id);
        $plus->delete();

        return redirect()->back()->with('delete', 'تم حذف البيانات بنجاح.');
    }
}

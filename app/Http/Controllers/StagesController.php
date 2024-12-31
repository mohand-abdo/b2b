<?php

namespace App\Http\Controllers;

use App\Models\Plus;
use App\Models\Tree4;
use App\Models\Stages;
use App\Models\Campaigns;
use App\Models\Operation;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Mail\StageCreated;

class StagesController extends Controller
{
    public function index(): View
    {
        if (Auth::user()->roles_name == 'owner') {
            $stages = Stages::get();
        } elseif (Auth::user()->roles_name == 'agent') {
            $stages = Stages::where('user_id', Auth::id())->get();
        }

        // $campaigns = Campaigns::where('status', 1)->get();

        return view('stages.index', compact('stages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'campaign_id' => 'required|string|max:255',
            'stage' => 'required',
        ]);
        $exists = Stages::where('campaign_id', $request->campaign_id)
            ->where('stage', $request->stage)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'المرحلة موجودة بالفعل لهذه الحملة.');
        }
        $stage = Stages::create([
            'campaign_id' => $request->campaign_id,
            'stage' => $request->stage,
            'user_id' => Auth::id(),
        ]);

        $tree4 = Tree4::where('status', '1')->get();
        foreach($tree4 as $tree)
        {
            if($tree->email != ''){
                Mail::to($tree->email)->send(new StageCreated($stage, $tree));
            }
        }
        return redirect()->route('Stages.index')->with('success', 'تم إضافة المرحلة بنجاح');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'campaign_id' => 'required|string|max:255',
            'stage' => 'required',
        ]);
        $id = $request->id;
        $campaign = Stages::find($id);

        $campaign->campaign_id = $request->campaign_id;
        $campaign->stage = $request->stage;

        $campaign->save();
        Session()->flash('edit');

        return redirect()->route('Stages.index')->with('edit', 'تم تحديث المرحلة بنجاح');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate(
            rules: [
                'id' => ['required', 'exists:stages,id'],
                [
                    'id.required' => 'معرف المرحلة مطلوب.',
                    'id.exists' => 'المرحلة المحددة غير موجودة.',
                ],
            ],
        );
        $id = $request->id;
        Stages::find($id)->delete();
        session()->flash('delete');

        return redirect()->route('Stages.index')->with('success', 'تم حذف المرحلة بنجاح');
    }

    public function search(): View
    {
        return view('stages.search');
    }

    public function search_post(Request $request): View
    {
        $start = $request->start;
        $end = $request->end;
        $name = Campaigns::findOrFail($request->campaign)->name;
        $Madin = Operation::with('plus')
            ->whereHas(
                'plus',
                callback: function ($query) use ($request) {
                    $query->where('campaign_id', $request->campaign); // الشرط بناءً على campaign_id
                },
            )
            ->whereDate('created_at', '>=', $request->start)
            ->whereDate('created_at', '<=', $request->end)
            ->orderBy('id', 'DESC')
            ->where('Madin', 'like', '1205%');
        if (Auth::user()->roles_name == 'owner') {
            $Madin = $Madin->get();
        } elseif (Auth::user()->roles_name == 'agent') {
            $Madin = $Madin->where('user_id', Auth::id())->get();
        }
        $Dain = Operation::with('plus')
            ->whereHas(
                'plus',
                callback: function ($query) use ($request) {
                    $query->where('campaign_id', $request->campaign); // الشرط بناءً على campaign_id
                },
            )
            ->whereDate('created_at', '>=', $request->start)
            ->whereDate('created_at', '<=', $request->end)
            ->orderBy('id', 'DESC')
            ->where('Dain', 'like', '1205%');
        if (Auth::user()->roles_name == 'owner') {
            $Dain = $Dain->get();
        } elseif (Auth::user()->roles_name == 'agent') {
            $Dain = $Dain->where('user_id', Auth::id())->get();
        }

        return view('stages.show', compact('Madin', 'Dain', 'name', 'start', 'end'));
    }

    public function getCampaign(Request $request)
    {
        $search = $request->get('q');
        if ($search != null) {
            $campaigns = Campaigns::where('status', 1);
            if ($search != null) {
                $campaigns = $campaigns->where('name', 'LIKE', '%' . $search . '%')->get();
            }

            $formattedResults = $campaigns->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->name, // الحقل الذي سيظهر في Select2
                ];
            });

            return response()->json($formattedResults);
        }
    }

    public function transform(Request $request)
    {
        $request->validate(
            [
                'stage_id' => 'required|exists:stages,id',
                'campaign_id' => 'required|exists:campaigns,id',
            ],
            [
                'stage_id.required' => 'معرف المرحلة مطلوب.',
                'stage_id.exists' => 'المرحلة المحددة غير موجودة.',
                'campaign_id.required' => 'معرف الحملة مطلوب.',
                'campaign_id.exists' => 'الحملة المحددة غير موجودة.',
            ],
        );
        $stage_id = Stages::with('pluses')->find($request->stage_id);
        $check = Stages::with('pluses')->where('campaign_id', $request->campaign_id);
        if (Auth::user()->roles_name == 'owner') {
            $exists = $check->exists();
        } else {
            $exists = $check->where('user_id', Auth::id())->exists();
        }

        if (!$exists) {
            return redirect()->back()->with('error_stage', 'الحملة ليست  موجودة بالفعل.');
        } elseif (Auth::user()->roles_name == 'owner') {
            $stage = $check->first();
        } elseif (Auth::user()->roles_name == 'agent') {
            $stage = $check->where('user_id', Auth::id())->first();
        }
        if ($stage->pluses->isEmpty()) {
            foreach ($stage_id->pluses as $plus) {
                Plus::create(['stage_id' => $stage->id, 'campaign_id' => $request->campaign_id, 'tree4_code' => $plus->tree4_code, 'tree4_id' => $plus->tree4_id]);
                foreach ($stage_id->pluses as $plus) {
                    $plus->delete();
                }
            }
        } else {
            foreach ($stage->pluses as $plus) {
                $plus->update(['stage_id' => $stage->id, 'campaign_id' => $request->campaign_id]);
            }
        }
        return back()->with('success', 'تم تحويل المرحلة بنجاح.');
    }
}

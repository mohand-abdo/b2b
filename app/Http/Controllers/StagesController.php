<?php

namespace App\Http\Controllers;

use App\Models\Stages;
use App\Models\Campaigns;
use App\Models\Operation;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class StagesController extends Controller
{
    public function index(): View
    {
        if (Auth::user()->roles_name == 'owner') {
            $stages = Stages::get();
        } elseif (Auth::user()->roles_name == 'agent') {
            $stages = Stages::where('user_id', Auth::id())->get();
        }

        $campaigns = Campaigns::where('status', 1)->get();

        return view('stages.index', compact('campaigns', 'stages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'campaign_id' => 'required|string|max:255',
            'stage' => 'required',
        ]);
        $exists = Stages::where('campaign_id', $request->campaign_id)
            ->where('stage', $request->stage)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'المرحلة موجودة بالفعل لهذه الحملة.');
        }
        Stages::create([
            'campaign_id' => $request->campaign_id,
            'stage' => $request->stage,
            'user_id' => Auth::id(),
        ]);
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
        $campaigns = Campaigns::where('status', 1)->get();
        return view('stages.search', compact('campaigns'));
    }

    public function search_post(Request $request): View
    {
        $start = $request->start;
        $end = $request->end;
        $Madin = Operation::with('plus')->whereHas('plus', callback: function ($query) use ($request) {
            $query->where('campaign_id', $request->campaign); // الشرط بناءً على campaign_id
        })
            ->whereDate('created_at', '>=', $request->start)
            ->whereDate('created_at', '<=', $request->end)
            ->orderBy('id', 'DESC')
            ->where('Madin', 'like', '1205%')
            ->get();

            $Dain = Operation::with('plus')->whereHas('plus', callback: function ($query) use ($request) {
            $query->where('campaign_id', $request->campaign); // الشرط بناءً على campaign_id
        })
            ->whereDate('created_at', '>=', $request->start)
            ->whereDate('created_at', '<=', $request->end)
            ->orderBy('id', 'DESC')
            ->where('Dain', 'like', '1205%')
            ->get();

        return view('stages.show', compact('Madin','Dain', 'start', 'end'));
    }
}

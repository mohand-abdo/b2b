<?php

namespace App\Http\Controllers;

use App\Models\Campaigns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignsController extends Controller
{
    public function index()
    {
        $campaigns = Campaigns::all();

        return view('campaigns.index', compact('campaigns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Campaigns::create([
            'name' => $request->name,
            'date' => $request->date,
            'status' => 0, // Default status
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('campaigns.index')->with('success', 'تم إضافة الحملة بنجاح');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
        $id = $request->id;
        $campaign = Campaigns::find($id);

        $campaign->name = $request->name;
        $campaign->date = $request->date;

        $campaign->save();
        Session()->flash('edit');

        return redirect()->route('campaigns.index')->with('edit', 'تم تحديث الحملة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        Campaigns::find($id)->delete();
        session()->flash('delete');

        return redirect()->route('campaigns.index')->with('success', 'تم حذف الحملة بنجاح');
    }

    public function toggleStatus($id)
    {
        $campaign = Campaigns::findOrFail($id);
        $campaign->status = ! $campaign->status;
        $campaign->save();

        return response()->json(['status' => $campaign->status]);
    }
}
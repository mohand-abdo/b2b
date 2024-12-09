<?php

namespace App\Http\Controllers;

use App\Models\Campaigns;
use App\Models\Stages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stages = Stages::all();
        $campaigns = Campaigns::where('status',1)->get();

        return view('stages.index', compact('campaigns', 'stages'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Stages $stages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Stages $stages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Stages::find($id)->delete();
        session()->flash('delete');

        return redirect()->route('Stages.index')->with('success', 'تم حذف المرحلة بنجاح');
    }
}
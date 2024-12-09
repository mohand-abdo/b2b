<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree3;
use App\Models\Tree4;
use App\Models\Operation;

class DriversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree4s = Tree4::where('tree3_code',2302)->where('status',2)->get();
        $tree3s = Tree3::all();
        $id = 1;
        return view('drivers.drivers', compact('tree3s', 'tree4s', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $tree4s = Tree4::where('tree3_code',2302)->where('status',2)->get();
        return view('drivers.index', compact('tree4s'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $tree4 = new Tree4();

        $tree4->tree4_name = $request->tree4_name;
        $tree4->tree3_code =2302;
        $tree4->iden = $request->iden;
        $tree4->phone = $request->phone;
        $tree4->status = 2;
      
        $check = Tree4::where('tree3_code', 2302)->orderBy('id', 'DESC')->first();

        if ($check) {
            $tree4->tree4_code = $check->tree4_code + 1;
        } else {
            $tree4->tree4_code = ($tree4->tree3_code * 100000) + 1;
        }


        $tree4->save();

         Session()->flash('success');

        return redirect()->route('Drivers.index');
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
        $Madin = Operation::where('Madin', $request->tree4)->whereDate('date', '>=', $request->start)->whereDate('date', '<=', $request->end)->orderBy('id', 'DESC')->get();
        $Dain = Operation::where('Dain', $request->tree4)->whereDate('date', '>=', $request->start)->whereDate('date', '<=', $request->end)->orderBy('id', 'DESC')->get();

        $id = 1;

        return view('drivers.show', compact(
            'Madin',
            'Dain',
            'start',
            'end',
            'name',
            'id'
        
        ));
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
        $id = $request->id;
        $tree4 =  Tree4::find($id);

        $tree4->tree4_name = $request->tree4_name;
        $tree4->iden = $request->iden;
        $tree4->phone = $request->phone;
        $tree4->save();
         Session()->flash('edit');

         return redirect()->route('Drivers.index');
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
        return redirect()->route('Drivers.index');
    }
}

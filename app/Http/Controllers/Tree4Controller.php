<?php

namespace App\Http\Controllers;

use App\Models\Tree3;
use App\Models\Tree4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Tree4Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree4s = Tree4::all();
        $tree3s = Tree3::all();
        $id = 1;
        return view('tree4.index', compact('tree3s', 'tree4s', 'id'));
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
    public function store(Request $request)
    {

        $tree4 = new Tree4();

        $tree4->tree4_name = $request->tree4_name;
        $tree4->tree3_code = $request->tree3_code;


        $check = Tree4::where('tree3_code', $request->tree3_code)->orderBy('id', 'DESC')->first();

        if ($check) {
            $tree4->tree4_code = $check->tree4_code + 1;
        } else {
            $tree4->tree4_code = ($tree4->tree3_code * 100000) + 1;
        }


        $tree4->save();

         Session()->flash('success');

        return redirect()->route('tree4.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $tree4->save();
         Session()->flash('edit');

        return redirect()->route('tree4.index');
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
        return redirect()->route('tree4.index');
    }
}
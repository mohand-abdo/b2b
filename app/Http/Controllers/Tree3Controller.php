<?php

namespace App\Http\Controllers;

use App\Models\Tree2;
use App\Models\Tree3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Tree3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree2s = Tree2::all();
        $tree3s = Tree3::all();
        $id = 1;
        return view('tree3.index', compact('tree3s', 'tree2s', 'id'));
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
        $tree3 = new Tree3();

        $tree3->tree3_name = $request->tree3_name;
        $tree3->tree2_code = $request->tree2_code;


        $check = Tree3::where('tree2_code', $request->tree2_code)->orderBy('id', 'DESC')->first();

        if ($check) {
            $tree3->tree3_code = $check->tree3_code + 1;
        } else {
            $tree3->tree3_code = ($tree3->tree2_code * 100) + 1;
        }


        $tree3->save();

        Session()->flash('success');
        return redirect()->route('tree3.index');
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
        $tree3 =  Tree3::find($id);

        $tree3->tree3_name = $request->tree3_name;

        $tree3->save();

        Session()->flash('edit');
        return redirect()->route('tree3.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
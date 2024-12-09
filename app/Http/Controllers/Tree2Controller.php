<?php

namespace App\Http\Controllers;

use App\Models\Tree1;
use App\Models\Tree2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Tree2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree1s = Tree1::all();
        $tree2s = Tree2::all();
        $id = 1;
        return view('tree2.index', compact('tree1s', 'tree2s', 'id'));
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
        $tree2 = new Tree2();

        $tree2->tree2_name = $request->tree2_name;
        $tree2->tree1_code = $request->tree1_code;


        $check = Tree2::where('tree1_code', $request->tree1_code)->orderBy('id', 'DESC')->first();

        if ($check) {
            $tree2->tree2_code = $check->tree2_code + 1;
        } else {
            $tree2->tree2_code = ($tree2->tree1_code * 10) + 1;
        }


        $tree2->save();
        Session()->flash('success');
        return redirect()->route('tree2.index');
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
        $tree2 =  Tree2::find($id);

        $tree2->tree2_name = $request->tree2_name;

        $tree2->save();

        Session()->flash('success');
        return redirect()->route('tree2.index');
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree4;
use App\Models\Operation;

class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree4s = Tree4::all();
        return view('General.index', compact('tree4s'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // $name = $request->tree4;
        $Madin = Operation::whereDate('date', '>=', $request->start)->whereDate('date', '<=', $request->end)->orderBy('id', 'DESC')->get();
        $Dain = Operation::whereDate('date', '>=', $request->start)->whereDate('date', '<=', $request->end)->orderBy('id', 'DESC')->get();

        $id = 1;

        return view('General.show', compact(
            'Madin',
            'Dain',
            'id',
            

        
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
        //
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

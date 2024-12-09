<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree3;
use App\Models\Restrictions;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree3s = Tree3::all();
        return view('books.index', compact('tree3s'));
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
       $number  = $request->tree3;
        $one = Restrictions::where('tree4_code','LIKE',  $number.'%')->whereDate('date', '>=', $request->start)->whereDate('date', '<=', $request->end)->get();
        $Madin = Restrictions::where('tree4_code','LIKE',  $number.'%')->whereDate('date', '>=', $request->start)->whereDate('date', '<=', $request->end)->sum('Madin');
        $Dain = Restrictions::where('tree4_code','LIKE',  $number.'%')->whereDate('date', '>=', $request->start)->whereDate('date', '<=', $request->end)->sum('Dain');
        $start = $request->start;
        $end = $request->end;
        return view('books.show', compact('one','start','end','Madin','Dain'));
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Tree4;
use App\Models\Restrictions;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():View
    {
        $daily = Operation::where('type', 3)->get();
        $id = 1;
        return view('balance.index', compact( 'daily', 'id'));
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
        // $check =  Operation::latest()->first();
        $id_page = $request->id_page;
        if ($id_page == 1) {
            $daily =  new Operation;
            $daily->Dain = $request->account;
            $daily->price = $request->price;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
            $daily->Constraint_number = $request->Constraint_number;
            $daily->type = 3;  //type of openinig balance = 3
            $daily->user_id = Auth::user()->id;
            $daily->save();

            $op_id = Operation::latest()->first()->id;
            $daily =  new Restrictions;
            $daily->tree4_code = $request->account;
            $daily->Dain = $request->price;
            $daily->Madin = 0;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
            $daily->op_id =  $op_id;
            $daily->Constraint_number = $request->Constraint_number;
            $daily->type = 3;
            $daily->user_id = Auth::user()->id;
            $daily->save();
        } else {
            $daily =  new Operation;
            $daily->Madin = $request->account;
            $daily->price = $request->price;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
            $daily->Constraint_number = $request->Constraint_number;
            $daily->type = 3; //type of openinig balance = 3
            $daily->user_id = Auth::user()->id;
            $daily->save();

            $op_id = Operation::latest()->first()->id;
            $daily =  new Restrictions;
            $daily->tree4_code = $request->account;
            $daily->Madin = $request->price;
            $daily->Dain = 0;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
            $daily->op_id =  $op_id;
            $daily->Constraint_number = $request->Constraint_number;
            $daily->type = 3;
            $daily->user_id = Auth::user()->id;
            $daily->save();
        }
        Session()->flash('success');

        return redirect()->route('Balance.index');
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
        //
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
        Operation::find($id)->delete();
        session()->flash('delete');
        return redirect('/Balance');
    }
}

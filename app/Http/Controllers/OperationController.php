<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Tree4;
use App\Models\Restrictions;
use Illuminate\Support\Facades\Auth;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $daily = Operation::where('type', 1)->get();
        $daily = Operation::where('type', 1)->orderBy('created_at','desc')->take(5)->get();
        $id = 1;
        return view('Operation.index', compact( 'daily', 'id'));
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

        $this->validate($request, array(
            'Madin'        => 'required',
            'Dain'        => 'required',
            'price'        => 'required',
            'date'        => 'required',
        ));
        // $check =   $request->Constraint_number;
            $daily =  new Operation;
            $daily->Dain = $request->Dain;
            $daily->Madin = $request->Madin;
            $daily->price = $request->price;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
            $daily->Constraint_number =$request->Constraint_number;
            $daily->type = 1;
            $daily->user_id = Auth::user()->id;
            $daily->save();
            
            $op_id = Operation::latest()->first()->id;
            $daily =  new Restrictions;
            $daily->tree4_code = $request->Dain;
            $daily->Dain = $request->price;
            $daily->Madin = 0;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
            $daily->op_id =  $op_id;
            $daily->Constraint_number =$request->Constraint_number;
            $daily->type = 1;
            $daily->user_id = Auth::user()->id;
            $daily->save();

            $op_id = Operation::latest()->first()->id;
            $daily =  new Restrictions;
            $daily->tree4_code = $request->Madin;
            $daily->Dain = 0;
            $daily->Madin = $request->price;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
             $daily->op_id =  $op_id;
            $daily->Constraint_number =$request->Constraint_number;
            $daily->type = 1;
            $daily->user_id = Auth::user()->id;
            $daily->save();

       
        Session()->flash('success');

        return redirect()->route('Operation.index');
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
        // $sections=sections::find($id);
        // $sections->delete();
        Operation::find($id)->delete();
        session()->flash('delete');
        return redirect('/Operation');
    
    }
}

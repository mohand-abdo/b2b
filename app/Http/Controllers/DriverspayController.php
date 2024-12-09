<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Tree4;
use App\Models\Restrictions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriverspayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree4 = DB::table('tree4s')->where('tree3_code','=' ,'1202')->orWhere('tree3_code','=' ,'1203')->orWhere('tree3_code','=' ,'2302')->Where('status','=' ,'2')->get();
        // $tree4 = Tree4::where('tree3_code',2302)->orwhere('tree3_code',1203)->where('status',2)->get();
        // $daily = Operation::where('type', 1)->get();
        $daily = Operation::where('type', 10)->orderBy('created_at','desc')->take(5)->get();
        $id = 1;
        return view('drivers.drivers_pay', compact('tree4', 'daily', 'id'));
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
            $daily->type = 10;
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
            $daily->type = 10;
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
            $daily->type = 10;
            $daily->user_id = Auth::user()->id;
            $daily->save();

       
        Session()->flash('success');

        return redirect()->route('Drivers_Pay.index');
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
        return redirect('/Drivers_Pay');
    
    }
}

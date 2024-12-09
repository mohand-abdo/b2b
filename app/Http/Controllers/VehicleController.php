<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Tree4;
use App\Models\Restrictions;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree4 = Tree4::all();
        // $daily = Operation::where('type', 1)->get();
        $daily = Operation::where('type', 1)->orderBy('created_at','desc')->take(5)->get();
        $id = 1;
        return view('Vehicle.index', compact('tree4', 'daily', 'id'));
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
       if($request->price_tow > 0 && !empty($request->account_tow)){
            $daily =  new Operation;
            $daily->Dain = $request->account_one;
            $daily->Madin = $request->account_tow;
            $daily->price = $request->price_tow;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
            $daily->Constraint_number =$request->Constraint_number;
            $daily->type = 1;
            $daily->user_id = Auth::user()->id;
            $daily->save(); 

           
            $daily =  new Restrictions;
            $op_id_one = Operation::latest()->first()->id;
            $daily->tree4_code = $request->account_one;
            $daily->Dain = $request->price_tow;
            $daily->Madin = 0;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
            $daily->op_id =  $op_id_one;
            $daily->Constraint_number =$request->Constraint_number;
            $daily->type = 1;
            $daily->user_id = Auth::user()->id;
            $daily->save();

            
            $daily =  new Restrictions;
            $op_id_one = Operation::latest()->first()->id;
            $daily->tree4_code = $request->account_tow;
            $daily->Dain = 0;
            $daily->Madin = $request->price_tow;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
             $daily->op_id =  $op_id_one;
            $daily->Constraint_number =$request->Constraint_number;
            $daily->type = 1;
            $daily->user_id = Auth::user()->id;
            $daily->save();
        }else{
           
        }
        $all_id = Operation::latest()->first()->id;
        //three operations in the mult guood
        if($request->price_three > 0 && !empty($request->account_three)){
            $daily =  new Operation;
            $daily->Dain = $request->account_one;
            $daily->Madin = $request->account_three;
            $daily->price = $request->price_three;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
            $daily->Constraint_number =$request->Constraint_number;
            $daily->type = 1;
            $daily->user_id = Auth::user()->id;
            $daily->save(); 

            
            $daily =  new Restrictions;
            // $op_id_tow = Operation::latest()->first()->id;
            $daily->tree4_code = $request->account_one;
            $daily->Dain = $request->price_three;
            $daily->Madin = 0;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
            $daily->op_id =  $all_id +1;
            $daily->Constraint_number =$request->Constraint_number;
            $daily->type = 1;
            $daily->user_id = Auth::user()->id;
            $daily->save();

           
            $daily =  new Restrictions;
            // $op_id_tow = Operation::latest()->first()->id;
            $daily->tree4_code = $request->account_three;
            $daily->Dain = 0;
            $daily->Madin = $request->price_three;
            $daily->date = $request->date;
            $daily->Statement = $request->Statement;
             $daily->op_id =  $all_id +1;
            $daily->Constraint_number =$request->Constraint_number;
            $daily->type = 1;
            $daily->user_id = Auth::user()->id;
            $daily->save();
        }else{
          
        }

       // four operation in the mult gouuud 
       if($request->price_four > 0 && !empty($request->account_four)){
        $daily =  new Operation;
        $daily->Dain = $request->account_one;
        $daily->Madin = $request->account_four;
        $daily->price = $request->price_four;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
        $daily->Constraint_number =$request->Constraint_number;
        $daily->type = 1;
        $daily->user_id = Auth::user()->id;
        $daily->save(); 

       
        $daily =  new Restrictions;
        // $op_id_three = Operation::latest()->first()->id;
        $daily->tree4_code = $request->account_one;
        $daily->Dain = $request->price_four;
        $daily->Madin = 0;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
        $daily->op_id =  $all_id +2;
        $daily->Constraint_number =$request->Constraint_number;
        $daily->type = 1;
        $daily->user_id = Auth::user()->id;
        $daily->save();

        
        $daily =  new Restrictions;
        // $op_id_three = Operation::latest()->first()->id;
        $daily->tree4_code = $request->account_four;
        $daily->Dain = 0;
        $daily->Madin = $request->price_four;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
         $daily->op_id =   $all_id +2;
        $daily->Constraint_number =$request->Constraint_number;
        $daily->type = 1;
        $daily->user_id = Auth::user()->id;
        $daily->save();
    }else{
      
    }
    
    //five operations in the mult gouuud 
    if($request->price_five > 0 && !empty($request->account_five)){
        $daily =  new Operation;
        $daily->Dain = $request->account_one;
        $daily->Madin = $request->account_five;
        $daily->price = $request->price_five;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
        $daily->Constraint_number =$request->Constraint_number;
        $daily->type = 1;
        $daily->user_id = Auth::user()->id;
        $daily->save(); 

        
        $daily =  new Restrictions;
        // $op_id_four = Operation::latest()->first()->id;
        $daily->tree4_code = $request->account_one;
        $daily->Dain = $request->price_five;
        $daily->Madin = 0;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
        $daily->op_id =   $all_id +3;
        $daily->Constraint_number =$request->Constraint_number;
        $daily->type = 1;
        $daily->user_id = Auth::user()->id;
        $daily->save();

       
        $daily =  new Restrictions;
        // $op_id_four = Operation::latest()->first()->id;
        $daily->tree4_code = $request->account_five;
        $daily->Dain = 0;
        $daily->Madin = $request->price_five;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
         $daily->op_id =   $all_id +3;
        $daily->Constraint_number =$request->Constraint_number;
        $daily->type = 1;
        $daily->user_id = Auth::user()->id;
        $daily->save();
    }else{

    }

    //six operations in mult gouuuod 
    if($request->price_six > 0 && !empty($request->account_six)){
        $daily =  new Operation;
        $daily->Dain = $request->account_one;
        $daily->Madin = $request->account_six;
        $daily->price = $request->price_six;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
        $daily->Constraint_number =$request->Constraint_number;
        $daily->type = 1;
        $daily->user_id = Auth::user()->id;
        $daily->save(); 

        
        $daily =  new Restrictions;
        // $op_id_five = Operation::latest()->first()->id;
        $daily->tree4_code = $request->account_one;
        $daily->Dain = $request->price_six;
        $daily->Madin = 0;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
        $daily->op_id =   $all_id + 4;
        $daily->Constraint_number =$request->Constraint_number;
        $daily->type = 1;
        $daily->user_id = Auth::user()->id;
        $daily->save();

        
        $daily =  new Restrictions;
        // $op_id_five = Operation::latest()->first()->id;
        $daily->tree4_code = $request->account_six;
        $daily->Dain = 0;
        $daily->Madin = $request->price_six;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
         $daily->op_id =   $all_id + 4;
        $daily->Constraint_number =$request->Constraint_number;
        $daily->type = 1;
        $daily->user_id = Auth::user()->id;
        $daily->save();
    }else{
       
    }

       
        Session()->flash('success');

        return redirect()->route('Vehicle.index');
  
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
    public function destroy($id)
    {
        //
    }
}

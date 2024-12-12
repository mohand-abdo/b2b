<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Plus;
use App\Models\Tree4;
use App\Models\Restrictions;
use Illuminate\Support\Facades\Auth;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\DB;

class ClientPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree4 = DB::table('tree4s')->where('tree3_code', '=', '1202')->orWhere('tree3_code', '=', '1203')->Where('status', '=', '1');
        if (Auth::user()->roles_name == 'owner') {
            $tree4 = $tree4->orWhere('tree3_code', '=', '1205')->get();
        }elseif (Auth::user()->roles_name == 'agent'){
            $tree4 = $tree4->orWhere('tree3_code', '=', '1205')->where('user_id', Auth::id())->get();
        }
        // $tree4 = Tree4::all();
        // $daily = Operation::where('type', 1)->get();
        $daily = Operation::where('type', 8)->orderBy('created_at', 'desc')->get();
        $id = 1;
        return view('clients.client_pay', compact('tree4', 'daily', 'id'));
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
        $this->validate($request, [
            'Madin' => 'required',
            'Dain' => 'required',
            'price' => 'required',
            'date' => 'required',
        ]);
        $pluseId = Plus::orWhere('tree4_code', $request->Madin)
            ->orWhere('tree4_code', $request->Dain)
            ->latest()
            ->first();
        // $check =   $request->Constraint_number;
        $daily = new Operation();
        $daily->Dain = $request->Dain;
        $daily->Madin = $request->Madin;
        $daily->price = $request->price;
        $daily->date = $request->date;
        $daily->pluse_id = $pluseId->id;
        $daily->Statement = $request->Statement;
        $daily->Constraint_number = $request->Constraint_number;
        $daily->type = 8;
        $daily->user_id = Auth::user()->id;
        $daily->save();

        $op_id = Operation::latest()->first()->id;
        $daily = new Restrictions();
        $daily->tree4_code = $request->Dain;
        $daily->Dain = $request->price;
        $daily->Madin = 0;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
        $daily->op_id = $op_id;
        $daily->Constraint_number = $request->Constraint_number;
        $daily->type = 8;
        $daily->user_id = Auth::user()->id;
        $daily->save();

        $op_id = Operation::latest()->first()->id;
        $daily = new Restrictions();
        $daily->tree4_code = $request->Madin;
        $daily->Dain = 0;
        $daily->Madin = $request->price;
        $daily->date = $request->date;
        $daily->Statement = $request->Statement;
        $daily->op_id = $op_id;
        $daily->Constraint_number = $request->Constraint_number;
        $daily->type = 8;
        $daily->user_id = Auth::user()->id;
        $daily->save();

        Session()->flash('success');

        return redirect()->route('ClientPay.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = Operation::find($id);
        $numberToWords = new NumberToWords();

        // build a new number transformer using the RFC 3066 language identifier
        $numberTransformer = $numberToWords->getNumberTransformer('ar');
        return view('clients.bill', compact('bill', 'numberTransformer'));
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
        return redirect('/ClientPay');
    }
}

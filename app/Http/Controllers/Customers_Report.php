<?php

namespace App\Http\Controllers;

use App\Models\sections;
use App\Models\invoices;
use Illuminate\Http\Request;

class Customers_Report extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        return view('reports.customers_report',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Search_customers(Request $request)
    {
        
          //في خالة عدم تحديد التاريخ
       if($request->Section && $request->product && $request->start_at =='' && $request->end_at ==''){
        $invoices = invoices::select('*')->where('section_id','=',$request->Section)->
        where('product','=',$request->product)->get();
        $sections = sections::all();
        return view('reports.customers_report',compact('sections'))->withDetails($invoices);

        
       }
        //في حالة تحديد التاريخ
       else{
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);
        $invoices = invoices::whereBetween('invoice_Date',[ $start_at, $end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
        $sections = sections::all();
        return view('reports.customers_report',compact('sections'))->withDetails($invoices);


       }
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

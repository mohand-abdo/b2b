<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Models\Tree4;
use App\Models\Sale;

class Client_ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree4s = Tree4::where('tree3_code', 1205)->where('status',1)->get();
        return view('client_report.index', compact('tree4s'));
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
        $name = $request->tree4;
        $invoices = Invoices::where('client', $request->tree4)->whereDate('invoice_Date', '>=', $request->start)->whereDate('invoice_Date', '<=', $request->end)->where('Status',1)->get();
        $total = Invoices::where('client', $request->tree4)->whereDate('invoice_Date', '>=', $request->start)->whereDate('invoice_Date', '<=', $request->end)->where('Status',1)->sum('total');
        $endtotal = Invoices::where('client', $request->tree4)->whereDate('invoice_Date', '>=', $request->start)->whereDate('invoice_Date', '<=', $request->end)->where('Status',1)->sum('endtotal');
        $id = 1;
        $start = $request->start;
        $end = $request->end;

        return view('client_report.show', compact(
            'invoices',
            'id',
            'name',
            'total',
            'endtotal',
            'start',
            'end'


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

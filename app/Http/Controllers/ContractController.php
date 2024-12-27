<?php

namespace App\Http\Controllers;

use App\Models\Plus;
use App\Models\Tree4;
use App\Models\Contract;
use App\Models\Campaigns;
use App\Models\Operation;
use App\Models\Restrictions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    private $uploadPathLogo = 'image/contract/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree4s = Tree4::where('tree3_code', 2302)->where('status', 2)->get();
        $contracts = Contract::all();

        return view('contract.index', compact('contracts', 'tree4s'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tree4s = Tree4::whereIn('tree3_code', [1202, 1203])->get();
        return view('contract.contract', compact('tree4s'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $tree_code = $request->tree4_code;
        $check = Plus::where('campaign_id', $request->campaign_id)
            ->where('tree4_code', $tree_code)
            ->exists();
        // dd($check);
        if (!$check) {
            return back()->with('error', 'هناك خطأ ما!');
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'tree4_code' => 'required|exists:tree4s,tree4_code',
            'campaign_id' => 'required|exists:campaigns,id',
            'bank_and_safe' => 'required|exists:tree4s,tree4_code',
            'hajj_number' => 'required|string|max:255',
            'room_number' => 'required|string|max:255',
            'bus_number' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'tax' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'contract_date' => 'required|date',
            'contract_terms' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move($this->uploadPathLogo, $attachmentPath);
        }

        // Create Contract
        $contract = new Contract();
        $contract->tree4_code = $request->tree4_code;
        $contract->campaign_id = $request->campaign_id;
        $contract->bank_and_safe = $request->bank_and_safe;
        $contract->hajj_number = $request->hajj_number;
        $contract->room_number = $request->room_number;
        $contract->bus_number = $request->bus_number;
        $contract->amount = $request->amount;
        $contract->tax = $request->tax;
        $contract->total_amount = $request->total_amount;
        $contract->contract_date = $request->contract_date;
        $contract->contract_terms = $request->contract_terms;
        $contract->attachment = $attachmentPath;
        $contract->user_id = Auth::user()->id;
        $contract->save();

        // $contract->tree4_id = $contract->tree4->tree4_id;
        // $contract->save();
        $pluseId = Plus::where('tree4_code', $request->tree4_code)
            ->where('campaign_id', $request->campaign_id)
            ->first();

        // Get the contract ID
        $contractId = $contract->id;

        // Get the highest Constraint_number from Operation and increment it
        $lastConstraintNumber = Operation::max('Constraint_number');
        $newConstraintNumber = $lastConstraintNumber ? $lastConstraintNumber + 1 : 1;

        // Create Operation
        $operation = new Operation();
        $operation->Dain = $request->bank_and_safe;
        $operation->Madin = $request->tree4_code;
        $operation->price = $request->total_amount;
        $operation->date = $request->contract_date;
        $operation->plus_id = $pluseId == '' ? null : $pluseId->id;
        $operation->Constraint_number = $newConstraintNumber; // Set new Constraint_number
        $operation->invoice_number = $contractId; // Use contract ID
        $operation->type = 8;
        $operation->user_id = Auth::user()->id;
        $operation->save();

        // Create Restriction entries
        $op_id = $operation->id;
        $restriction1 = new Restrictions();
        $restriction1->tree4_code = $request->bank_and_safe;
        $restriction1->Dain = $request->total_amount;
        $restriction1->Madin = 0;
        $restriction1->date = $request->contract_date;
        $restriction1->op_id = $op_id;
        $restriction1->Constraint_number = $newConstraintNumber; // Set new Constraint_number
        $restriction1->invoice_number = $contractId; // Use contract ID
        $restriction1->type = 8;
        $restriction1->user_id = Auth::user()->id;
        $restriction1->save();

        $restriction2 = new Restrictions();
        $restriction2->tree4_code = $request->tree4_code;
        $restriction2->Dain = 0;
        $restriction2->Madin = $request->total_amount;
        $restriction2->date = $request->contract_date;
        $restriction2->op_id = $op_id;
        $restriction2->Constraint_number = $newConstraintNumber; // Set new Constraint_number
        $restriction2->invoice_number = $contractId; // Use contract ID
        $restriction2->type = 8;
        $restriction2->user_id = Auth::user()->id;
        $restriction2->save();

        Session()->flash('success', 'تمت العملية بنجاح');

        return redirect()->route('Contract.create');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Add this method in your ContractController
    public function edit($id)
    {
        $contract = Contract::findOrFail($id); // Find the contract by ID
        $tree4s = Tree4::all(); // Fetch all available banks and safes

        return view('contract.edit', compact('contract', 'tree4s'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    // Add this method in your ContractController
    public function update(Request $request, $id): RedirectResponse
    {
        $tree_code = $request->tree4_code;
        $check = Plus::where('campaign_id', $request->campaign_id)
            ->where('tree4_code', $tree_code)
            ->exists();
        if (!$check) {
            return back()->with('error', 'هناك خطأ ما!');
        }
        // Validation
        $validator = Validator::make($request->all(), [
            'tree4_id' => 'required|exists:tree4s,id',
            'campaign_id' => 'required|exists:campaigns,id',
            'bank_and_safe' => 'required|exists:tree4s,tree4_code',
            'hajj_number' => 'required|string|max:255',
            'room_number' => 'required|string|max:255',
            'bus_number' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'tax' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'contract_date' => 'required|date',
            'contract_terms' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the existing contract
        $contract = Contract::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move($this->uploadPathLogo, $attachmentPath);
            $contract->attachment = $attachmentPath;
        }

        // Update contract details
        $contract->tree4_code = $request->tree4_code;
        $contract->campaign_id = $request->campaign_id;
        $contract->bank_and_safe = $request->bank_and_safe;
        $contract->hajj_number = $request->hajj_number;
        $contract->room_number = $request->room_number;
        $contract->bus_number = $request->bus_number;
        $contract->amount = $request->amount;
        $contract->tax = $request->tax;
        $contract->total_amount = $request->total_amount;
        $contract->contract_date = $request->contract_date;
        $contract->contract_terms = $request->contract_terms;
        $contract->user_id = Auth::user()->id;
        $contract->save();

        // $contract->tree4_id = $contract->tree4->tree4_id;
        // $contract->save();

        $pluseId = Plus::where('tree4_code', $request->tree4_code)
            ->where('campaign_id', $request->campaign_id)
            ->first();

        // Get the highest Constraint_number from Operation and increment it
        $lastConstraintNumber = Operation::max('Constraint_number');
        $newConstraintNumber = $lastConstraintNumber ? $lastConstraintNumber + 1 : 1;

        // Update or create Operation
        $operation = Operation::where('invoice_number', $contract->id)->first();
        if (!$operation) {
            // Create a new Operation if it doesn't exist
            $operation = new Operation();
            $operation->Constraint_number = $newConstraintNumber; // Set new Constraint_number
        }
        $operation->Dain = $request->bank_and_safe;
        $operation->Madin = $request->tree4_code;
        $operation->price = $request->total_amount;
        $operation->date = $request->contract_date;
        $operation->plus_id = $pluseId == '' ? null : $pluseId->id;
        $operation->invoice_number = $contract->id; // Use contract ID
        $operation->type = 8;
        $operation->user_id = Auth::user()->id;
        $operation->save();

        // Update Restrictions entries
        $restriction1 = Restrictions::where('op_id', $operation->id)
            ->where('Madin', 0)
            ->first();
        if (!$restriction1) {
            // Create a new Restrictions record if it doesn't exist
            $restriction1 = new Restrictions();
            $restriction1->op_id = $operation->id;
            $restriction1->Constraint_number = $newConstraintNumber; // Set new Constraint_number
        }
        $restriction1->tree4_code = $request->bank_and_safe;
        $restriction1->Dain = $request->total_amount;
        $restriction1->Madin = 0;
        $restriction1->date = $request->contract_date;
        $restriction1->invoice_number = $contract->id; // Use contract ID
        $restriction1->type = 8;
        $restriction1->user_id = Auth::user()->id;
        $restriction1->save();

        $restriction2 = Restrictions::where('op_id', $operation->id)
            ->where('Dain', 0)
            ->first();
        if (!$restriction2) {
            // Create a new Restrictions record if it doesn't exist
            $restriction2 = new Restrictions();
            $restriction2->op_id = $operation->id;
            $restriction2->Constraint_number = $newConstraintNumber; // Set new Constraint_number
        }
        $restriction2->tree4_code = $request->tree4_code;
        $restriction2->Dain = 0;
        $restriction2->Madin = $request->total_amount;
        $restriction2->date = $request->contract_date;
        $restriction2->invoice_number = $contract->id; // Use contract ID
        $restriction2->type = 8;
        $restriction2->user_id = Auth::user()->id;
        $restriction2->save();

        Session()->flash('edit', 'تمت العملية بنجاح');

        return redirect()->route('Contract.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $contract = Contract::find($id);

        if ($contract) {
            // حذف السجلات المرتبطة في جدول operations باستخدام invoice_number
            Operation::where('invoice_number', $id)->delete();

            // حذف السجلات المرتبطة في جدول restrictions باستخدام invoice_number
            Restrictions::where('invoice_number', $id)->delete();

            // حذف العقد
            $contract->delete();

            session()->flash('delete', 'تم الحذف بنجاح');

            return redirect()->route('Contract.index');
        } else {
            session()->flash('error', 'لم يتم العثور على العقد');
            return redirect()->route('Contract.index');
        }
    }

    public function Contract_print($id)
    {
        $id_id = 1;
        $contract = contract::find($id);

        return view('contract.bill', compact('contract', 'id_id'));
    }

    //insert new client in invoice initial  add

    public function Contract_scan($id)
    {
        $invoices = contract::where('id', $id)->first();

        return view('contract.scan', compact('invoices'));
    }
}

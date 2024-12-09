<?php

namespace App\Http\Livewire;

use App\Models\Products as ModelsComponent;
use App\Models\Operation;
use App\Models\Sale;
use App\Models\Cars;
use App\Models\Travel;
use App\Models\Restrictions;
use App\Models\Invoices;
use App\Models\Root;
use App\Models\Pakages;
use App\Models\Tree4;
use App\Models\Setting;
use  App\Models\Transport_Setting;
use Illuminate\Support\Facades\Auth;


use Livewire\Component;

class Transport extends Component
{

    public $selectedMyComponent = Null;

    public $number;
    public $travel;
    public $to;
    public $car;
    public $price;
    public $erorr;
    public $total = 0;
    public $endtotal = 0;
    public $vat_value;   //select vat value
    public $value = 0;
    public $discount = 0;
    //الاجمالي دون الضريبة ناقص الخصم
    public $total_frist;
    //الاجمالي مع الضريبة ناقص الخصم
    public $total_tow;
    public $erorr_2;
    public $Statement;
    public $date;
    public $user_id;
    public $root;
    public $live_bank_and_safe;
    public $live_client;
    public $pay_type;

    public function mount()
    {
        $this->root = Root::where('status', 0)->get();

        $this->total = 0;
        $this->endtotal = 0;
        $this->value = 0;

        $this->date = now()->format('Y-m-d');
        //select vat value
        $setting = Transport_Setting::first();
        $this->vat_value = $setting->vat_value;
        //select vat value
        // $this->total = 0;
        // foreach ($this->root as $item) {
        //     $this->total += (int)$item->price * 1;
        // }

        foreach ($this->root as $item) {
            $this->total += (int)$item->price * 1;
            $this->value += (int)$item->price * 1 * $this->vat_value / 100;
            $this->endtotal = $this->total + $this->value;
        }
    }
    public function render()
    {

        $all_component = ModelsComponent::all();
        $client = Tree4::where('tree3_code', '1205')->where('status', 2)->get();
        $bank_and_safe = Tree4::where('tree3_code', '1203')->orWhere('tree3_code', '1202')->get();
        $cars = Cars::all();
        $travels = Travel::all();
        $id = 1;
        return view('livewire.transport', compact('client', 'bank_and_safe', 'id', 'all_component', 'cars', 'travels'));
    }

    public function add()
    {

        if ($this->travel == '' || $this->to == '' || $this->price == '') {
            $this->erorr = 'كل الحقول مطلوبة';
        } else {

            $root = new Root();
            $root->travel = $this->travel;
            $root->to = $this->to;
            $root->price = $this->price;
            $root->status = 0;
            // لايجاد اخر العروض
            $check = Root::where('status', 0)->orderBy('id', 'DESC')->first();
            $check_2 = Root::orderBy('id', 'DESC')->first();
            if ($check) {
                $root->number = $check->number;
            } elseif ($check_2) {
                $root->number = $check_2->number + 1;
            } else {
                $root->number =  1;
            }
            $root->save();
            $this->root = Root::where('status', 0)->get();

            $this->travel = '';
            $this->to     = '';
            $this->price    = '';

            $this->total = 0;
            $this->value = 0;
            $this->endtotal = 0;

            foreach ($this->root as $item) {
                $this->total += (int)$item->price * 1;
                $this->value += (int)$item->price * 1 * $this->vat_value / 100;
                $this->endtotal = $this->total + $this->value;
            }
        }
    }
    // deltet item form the sales 
    public function deletItem($id)
    {
        $root = Root::findOrfail($id);
        $root->delete();
        $this->root = Root::where('status', 0)->get();

        $this->travel = '';
        $this->to      = '';
        $this->price    = '';

        $this->total = 0;
        $this->value = 0;
        $this->endtotal = 0;

        foreach ($this->root as $item) {
            $this->total += (int)$item->price * 1;
            $this->value += (int)$item->price * 1 * $this->vat_value / 100;
            $this->endtotal = $this->total + $this->value;
        }
    }
    // insert invoices
    public function add_purchase()
    {
        $this->live_bank_and_safe;
        $this->live_client;
        $this->car;
        $this->total;
        $this->date;
        $this->Statement;
        //الاجمالي دون الضريبة ناقص الخصم
        $this->total_frist =  $this->total - $this->discount;
        //الاجمالي مع الضريبة ناقص الخصم
        $this->total_tow =  $this->endtotal - $this->discount;

        if ($this->pay_type == '' || $this->live_client == '' || $this->live_bank_and_safe == '' || $this->car == '') {
            $this->erorr_2 = 'كل الحقول مطلوبة';
        } elseif ($this->total > 0) {

            //للتحقق من اخر رقم في العروض
            $check_for_number = Root::where('status', 0)->orderBy('id', 'DESC')->first();

            //اذاكان البيع نقدي
            if ($this->pay_type == 1) {
                //chec_number of sales
                $check_for_number = Root::where('status', 0)->orderBy('id', 'DESC')->first();

                $daily =  new Operation();
                $check =  Operation::orderBy('id', 'DESC')->first();
                $daily->Dain = $this->live_client;
                // $daily->Madin = '';   //البنك او الخزينة
                $daily->price =  $this->total_tow;
                $daily->Statement = $this->Statement;
                $daily->date = $this->date;
                // $daily->purchases_number = $check_for_number->number;
                $daily->type = 5;
                if ($check) {
                    $daily->Constraint_number     = $check->Constraint_number + 1;
                } else {
                    $daily->Constraint_number     =  1;
                }
                $daily->transport_number = $check_for_number->number;
                $daily->user_id = Auth::user()->id;
                $daily->save();
                /// madin الخزنة
                $daily =  new Operation();
                $check =  Operation::orderBy('id', 'DESC')->first();
                // $daily->Dain ='';
                $daily->Madin = $this->live_bank_and_safe;   //البنك او الخزينة
                $daily->price = $this->total_tow;
                $daily->Statement = $this->Statement;
                $daily->date = $this->date;
                // $daily->purchases_number = $check_for_number->number;
                $daily->type = 5;
                if ($check) {
                    $daily->Constraint_number     = $check->Constraint_number + 1;
                } else {
                    $daily->Constraint_number     =  1;
                }
                $daily->transport_number = $check_for_number->number;
                $daily->user_id = Auth::user()->id;
                $daily->save();
                /// madin المبيعات
                $daily =  new Operation();
                $check =  Operation::orderBy('id', 'DESC')->first();
                //   $daily->Dain ='';
                $daily->Madin =  410100002; //حساب المبيعات   //البنك او الخزينة
                $daily->price = $this->total_tow;
                $daily->Statement = $this->Statement;
                $daily->date = $this->date;
                // $daily->purchases_number = $check_for_number->number;
                $daily->type = 5;
                if ($check) {
                    $daily->Constraint_number     = $check->Constraint_number + 1;
                } else {
                    $daily->Constraint_number     =  1;
                }
                $daily->transport_number = $check_for_number->number;
                $daily->user_id = Auth::user()->id;
                $daily->save();

                ////////////////////////////////
                $daily =  new Restrictions;
                $op_id_one = Operation::latest()->first()->id;
                $daily->tree4_code = $this->live_client;
                $daily->Dain = $this->total_tow;
                $daily->Madin = 0;
                $daily->date =  $this->date;
                $daily->Statement = $this->Statement;
                $daily->op_id =  $op_id_one;
                if ($check) {
                    $daily->Constraint_number     = $check->Constraint_number + 1;
                } else {
                    $daily->Constraint_number     =  1;
                }
                $daily->transport_number = $check_for_number->number;
                $daily->type = 5;
                $daily->user_id = Auth::user()->id;
                $daily->save();
                /////////////////////////////////////
                ////////////////////////////////
                $daily =  new Restrictions;
                $op_id_one = Operation::latest()->first()->id;
                $daily->tree4_code = $this->live_bank_and_safe;
                $daily->Dain = 0;
                $daily->Madin = $this->total_tow;
                $daily->date =  $this->date;
                $daily->Statement = $this->Statement;
                $daily->op_id =  $op_id_one;
                if ($check) {
                    $daily->Constraint_number     = $check->Constraint_number + 1;
                } else {
                    $daily->Constraint_number     =  1;
                }
                $daily->transport_number = $check_for_number->number;
                $daily->type = 5;
                $daily->user_id = Auth::user()->id;
                $daily->save();
                ////////////////////////////////
                $daily =  new Restrictions;
                $op_id_one = Operation::latest()->first()->id;
                $daily->tree4_code = 410100002; //حساب المبيعات
                $daily->Dain = 0;
                $daily->Madin = $this->total_tow;
                $daily->date =  $this->date;
                $daily->Statement = $this->Statement;
                $daily->op_id =  $op_id_one;
                if ($check) {
                    $daily->Constraint_number     = $check->Constraint_number + 1;
                } else {
                    $daily->Constraint_number     =  1;
                }
                $daily->transport_number = $check_for_number->number;
                $daily->type = 5;
                $daily->user_id = Auth::user()->id;
                $daily->save();
            }
            //اذاكان البيع اجل
            else {
                //chec_number of sales
                $check_for_number = Root::where('status', 0)->orderBy('id', 'DESC')->first();

                $daily =  new Operation();
                $check =  Operation::orderBy('id', 'DESC')->first();
                $daily->Dain =     410100002; //حساب المبيعات
                $daily->Madin = $this->live_client;   //البنك او الخزينة
                $daily->price = $this->total_tow;
                $daily->Statement = $this->Statement;
                $daily->date = $this->date;
                // $daily->purchases_number = $check_for_number->number;
                $daily->type = 5;
                if ($check) {
                    $daily->Constraint_number     = $check->Constraint_number + 1;
                } else {
                    $daily->Constraint_number     =  1;
                }
                $daily->transport_number = $check_for_number->number;
                $daily->user_id = Auth::user()->id;
                $daily->save();

                ////////////////////////////////
                $daily =  new Restrictions;
                $op_id_one = Operation::latest()->first()->id;
                $daily->tree4_code = 410100002;
                $daily->Dain = $this->total_tow;
                $daily->Madin = 0;
                $daily->date =  $this->date;
                $daily->Statement = $this->Statement;
                $daily->op_id =  $op_id_one;
                if ($check) {
                    $daily->Constraint_number     = $check->Constraint_number + 1;
                } else {
                    $daily->Constraint_number     =  1;
                }
                $daily->transport_number = $check_for_number->number;
                $daily->type = 5;
                $daily->user_id = Auth::user()->id;
                $daily->save();
                /////////////////////////////////////
                ////////////////////////////////
                $daily =  new Restrictions;
                $op_id_one = Operation::latest()->first()->id;
                $daily->tree4_code = $this->live_client;
                $daily->Dain = 0;
                $daily->Madin = $this->total_tow;
                $daily->date =  $this->date;
                $daily->Statement = $this->Statement;
                $daily->op_id =  $op_id_one;
                if ($check) {
                    $daily->Constraint_number     = $check->Constraint_number + 1;
                } else {
                    $daily->Constraint_number     =  1;
                }
                $daily->transport_number = $check_for_number->number;
                $daily->type = 5;
                $daily->user_id = Auth::user()->id;
                $daily->save();
            }
            $daily =  new Pakages;
            $daily->number = $check_for_number->number;
            $daily->date = $this->date;
            $daily->client = $this->live_client;
            $daily->car = $this->car;
            $daily->pay = $this->pay_type;
            $daily->discount =  $this->discount;
            $daily->total = $this->total_frist;
            $daily->vat_value =  $this->vat_value;
            $daily->value =  $this->value;
            $daily->endtotal = $this->total_tow;
            $daily->Statement = $this->Statement;
            $daily->Status = 1;
            $daily->user_id = Auth::user()->id;
            $daily->save();

            foreach ($this->root as $item) {
                $item->status = 1;
                $item->save();
            }

            $this->erorr = '';
            $this->total = 0;
            $this->erorr_2 = '';
            $this->pay_type;
            // Session()->flash('Add');
            return redirect()->route('Transport-print', $daily->id);
        } else {

            $this->erorr_2 = 'كل الحقول مطلوبة';
        }
    }
}

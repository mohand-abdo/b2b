<?php

namespace App\Http\Livewire;

use App\Models\Products as ModelsComponent;
use App\Models\Operation;
use App\Models\Sale;
use App\Models\Tree4;
use App\Models\Setting;
use App\Models\Restrictions;
use App\Models\Invoices;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Initial extends Component
{
    public $selectedMyComponent = Null;

    public $product_name;
    public  $unit_id;
    public $amount;
    public $price;
    public $erorr;
    public $erorr_2;
    public $total = 0;
    public $endtotal = 0;
    public $Statement;
    public $vat_value;   //select vat value
    public $value = 0;
    public $discount = 0;
    //الاجمالي دون الضريبة ناقص الخصم
    public $total_frist;
    //الاجمالي مع الضريبة ناقص الخصم
    public $total_tow;
    public $pay_type;
    public $invoice_Date;


    public $live_bank_and_safe;
    public $live_client;

    public $sales;

    public function mount()
    {
        $this->sales = Sale::where('status', 0)->get();

        $this->total = 0;
        $this->endtotal = 0;
        $this->value = 0;
        $this->invoice_Date = now()->format('Y-m-d');

        //select vat value
        $setting = Setting::first();
        $this->vat_value = $setting->vat_value;
        //select vat value

        foreach ($this->sales as $item) {
            $this->total += (int)$item->price * (int)$item->amount;
            $this->value += (int)$item->price * (int)$item->amount * $this->vat_value / 100;
            $this->endtotal = $this->total + $this->value;
        }
    }
    public function render()
    {
        $all_component = ModelsComponent::all();
        $client = Tree4::where('tree3_code', '1205')->where('status',1)->get();
        $bank_and_safe = Tree4::where('tree3_code', '1203')->orWhere('tree3_code', '1202')->get();
        $id = 1;
        return view('livewire.initial', compact('client', 'bank_and_safe', 'id', 'all_component'));
    }
    public function add()
    {

        if ($this->product_name == '' || $this->unit_id == '' || $this->amount == '' || $this->price == '') {
            $this->erorr = 'كل الحقول مطلوبة';
        } else {

            $sales = new Sale();
            $sales->component = $this->product_name;
            $sales->unit = $this->unit_id;
            $sales->amount = $this->amount;
            $sales->amount_in_store = $this->amount;

            $sales->price = $this->price;
            $sales->status = 0;

            // لايجاد اخر المشتريات
            $check = Sale::where('status', 0)->orderBy('id', 'DESC')->first();

            $check_2 = Sale::orderBy('id', 'DESC')->first();

            if ($check) {
                $sales->number = $check->number;
            } elseif ($check_2) {
                $sales->number = $check_2->number + 1;
            } else {
                $sales->number =  1;
            }
            $sales->save();


            $this->sales = Sale::where('status', 0)->get();

            $this->product_name = '';
            $this->unit_id      = '';
            $this->amount    = '';
            $this->price     = '';
            $this->erorr     = '';
            $this->selectedMyComponent     = '';


            $this->total = 0;
            $this->value = 0;
            $this->endtotal = 0;

            foreach ($this->sales as $item) {
                $this->total += (int)$item->price * (int)$item->amount;
                $this->value += (int)$item->price * (int)$item->amount * $this->vat_value / 100;
                $this->endtotal = $this->total + $this->value;
            }
        }
    }
    public function updatedSelectedMyComponent($state)
    {
        if (!is_null($state) && $state != '') {

            $this->product_name = ModelsComponent::find($state)->product_name;
            $this->unit_id = ModelsComponent::find($state)->unit->name;
            $this->price = ModelsComponent::find($state)->price;
            // $this->unit = 44;
        } else {
            $this->unit_id = '';
            $this->price = '';
        }
    }

    public function updatedSelectedSupplier($state)
    {
        if (!is_null($state)) {
            $this->unit_id = 44;
        }
    }
    // deltet item form the sales 
    public function deletItem($id)
    {
        $sales = Sale::findOrfail($id);
        $sales->delete();

        // $this->sales = Sale::where('number', $this->Daily_restriction->purchases_number)->get();



        $this->sales = Sale::where('status', 0)->get();

        $this->product_name = '';
        $this->unit_id      = '';
        $this->amount    = '';
        $this->price     = '';
        $this->erorr     = '';
        $this->selectedMyComponent     = '';


        $this->total = 0;
        $this->value = 0;
        $this->endtotal = 0;

        foreach ($this->sales as $item) {
            $this->total += (int)$item->price * (int)$item->amount;
            $this->value += (int)$item->price * (int)$item->amount * $this->vat_value / 100;
            $this->endtotal = $this->total + $this->value;
        }
    }

    // insert invoices
    public function add_purchase()
    {
        $this->live_bank_and_safe;
        $this->live_client;
        $this->total;

           //الاجمالي دون الضريبة ناقص الخصم
           $this->total_frist=  $this->total - $this->discount;
           //الاجمالي مع الضريبة ناقص الخصم
           $this->total_tow=  $this->endtotal - $this->discount;

        if ($this->live_client == '' || $this->pay_type == '') {
            $this->erorr_2 = 'كل الحقول مطلوبة';
        } elseif ($this->total > 0) {

            //للتحقق من اخر رقم في المبيعات
            $check_for_number = Sale::where('status', 0)->orderBy('id', 'DESC')->first();

            // foreach ($this->sales as $item) {
            //     $item->status = 2;
            //     $item->save();
            // }
            ///insert in invoices table
            $daily =  new Invoices;
            $daily->invoice_number = $check_for_number->number;
            $daily->invoice_Date = $this->invoice_Date;
            $daily->client = $this->live_client;
            $daily->pay = $this->pay_type;
            $daily->discount =  $this->discount;
            $daily->total = $this->total_frist;
            $daily->vat_value =  $this->vat_value;
            $daily->value =  $this->value;
            $daily->endtotal = $this->total_tow;
            $daily->Status = 2;
            $daily->Statement = $this->Statement;

            $daily->user_id = Auth::user()->id;
            $daily->save();

            foreach ($this->sales as $item) {
                $item->status = 2;
                $item->save();
            }


            // $this->live_bank_and_safe = '';
            $this->live_client = '';
            $this->Statement = '';
            $this->pay_type;
            $this->total = 0;
            $this->erorr = '';
            $this->erorr_2 = '';
            // $this->sales = Operation::where('status', 0)->get();
            return redirect()->route('Initial-print', $daily->id);
        } else {
            $this->erorr_2 = 'كل الحقول مطلوبة';
        }
    }
}

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
use App\Models\Contract;
use App\Models\Tree4;
use App\Models\Setting;
use App\Models\Passengers_Contract;
use App\Models\detection;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Contracts extends Component
{
    public $selectedMyComponent = Null;

    public $number;
    public $date;
    public $second_party;
    public $car;
    public $driver;
    public $travel;
    public $from;
    public $to;
    public $Statement;
    public $user_id;
    public $erorr;
    public $erorr_2;
    public $name;
    public $nationalty;
    public $passport;
    public $phone;
    public $Passenger;
    public $Pass;
    public function mount()
    {
        $this->Passenger = Passengers_Contract::where('status', 0)->get();


        $this->date = now()->format('Y-m-d');
    }

    public function render()
    {
        $all_component = ModelsComponent::all();
        $drivers = Tree4::where('tree3_code', '2302')->where('status', 2)->get();
        $cars = Cars::all();
        $travels = Travel::all();
        $id = 1;
        return view('livewire.contracts', compact('drivers', 'id', 'all_component', 'cars', 'travels'));
    }
    public function add()
    {

        if ($this->name == '' || $this->nationalty == '' || $this->passport == '') {
            $this->erorr = 'كل الحقول مطلوبة';
        } else {

            $Passenger = new Passengers_Contract();
            $Passenger->name = $this->name;
            $Passenger->nationalty = $this->nationalty;
            $Passenger->passport = $this->passport;
            $Passenger->phone = $this->phone;
            $Passenger->status = 0;
            // لايجاد اخر العروض
            $check = Passengers_Contract::where('status', 0)->orderBy('id', 'DESC')->first();
            $check_2 = Passengers_Contract::orderBy('id', 'DESC')->first();
            if ($check) {
                $Passenger->number = $check->number;
            } elseif ($check_2) {
                $Passenger->number = $check_2->number + 1;
            } else {
                $Passenger->number = 1;
            }
            $Passenger->save();
            $this->Passenger = Passengers_Contract::where('status', 0)->get();

            $this->name = '';
            $this->nationalty = '';
            $this->passport = '';
            $this->phone = '';

        }
    }

    // deltet item form the sales
    public function deletItem($id)
    {
        $Passengers = Passengers_Contract::findOrfail($id);
        $Passengers->delete();
        $this->Passenger = Passengers_Contract::where('status', 0)->get();

        $this->name = '';
        $this->nationalty = '';
        $this->passport = '';
        $this->phone = '';
    }


    // insert invoices
    public function add_purchase()
    {

     $this->Pass = Passengers_Contract::where('status', 0)->orderBy('id', 'DESC')->count();
     $this->second_party;
     $this->car;
        $this->driver;
        $this->from;
        $this->to;
        $this->Statement;




        if ($this->car == '' || $this->driver == '' || $this->from == '' || $this->to == '' || $this->second_party == '') {
            $this->erorr_2 = 'كل الحقول مطلوبة';
        } elseif ($this->Pass > 0) {
            //للتحقق من اخر رقم في العروض
            $check_for_number = Passengers_Contract::where('status', 0)->orderBy('id', 'DESC')->first();
            $daily = new Contract;
            $daily->number = $check_for_number->number;
            $daily->date = $this->date;
            $daily->second_party = $this->second_party;
            $daily->driver = $this->driver;
            $daily->car = $this->car;
            $daily->from = $this->from;
            $daily->to = $this->to;
            $daily->Statement = $this->Statement;
            $daily->Status = 1;
            $daily->user_id = Auth::user()->id;
            $daily->save();

            foreach ($this->Passenger as $item) {
                $item->status = 1;
                $item->save();
            }

            $this->erorr = '';
            $this->erorr_2 = '';
            // Session()->flash('Add');
            return redirect()->route('Contract-print', $daily->id);
            // return redirect('Add_pakage');
        } else {

            $this->erorr_2 = 'كل الحقول مطلوبة';
        }
    }
}
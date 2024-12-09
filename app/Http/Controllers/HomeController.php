<?php

namespace App\Http\Controllers;

use App\Models\Campaigns;
use App\Models\Restrictions;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //بخصوص الرسم البياني
        //=================احصائية الدائن والمدين النقدية بالبنوك  الحالات======================
        $cash_dain = Restrictions::where('tree4_code', 'LIKE', '1203%')->sum('Dain');
        $cash_madin = Restrictions::where('tree4_code', 'LIKE', '1203%')->sum('Madin');

        //=================احصائية الدائن والمدين بالبنوك بالخزن  الحالات======================
        $all = Campaigns::count();
        $active = Campaigns::where('status', 1)->count();
        $unactive = Campaigns::where('status', 0)->count();
        //بخصوص الرسم البياني

        //=================ناتج رصيد الايرادات   الحالات======================
        $cash_balance = $cash_madin - $cash_dain;

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['  المدين', ' الرصيد', '  الدائن'])
            ->datasets([
                [
                    'label' => ' المدين ',
                    'backgroundColor' => ['#ec5858'],
                    'data' => [round($cash_madin)],
                ],
                [
                    'label' => ' الرصيد',
                    'backgroundColor' => ['#81b214'],
                    'data' => [round($cash_balance)],
                ],
                [
                    'label' => ' الدائن',
                    'backgroundColor' => ['#ff9642'],
                    'data' => [round($cash_dain)],
                ],

            ])
            ->options([]);

        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['  الغير نشطة', ' النشطة', '  عدد الحملات'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214', '#ff9642'],
                    'data' => [round($unactive), round($active), round($all)],
                ],
            ])
            ->options([]);

        return view('home', compact(

            'chartjs',
            'chartjs_2',
        ));
    }
}
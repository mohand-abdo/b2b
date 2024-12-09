@extends('layouts.master')
@section('css')
<style>
    @media print {
        #print_Button {
            display: none !important;
        }
    }
</style>
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الحسابات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ كشف عام للحسابات
            </span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row row-sm">
    <div class="col-md-12 col-xl-12">
        <div class=" main-content-body-invoice" id="print">
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="invoice-header">
                        
                        <h1 class="invoice-title">كشثف حساب <span></span></h1>
                        <div class="billed-from">
                            <div class="col"> <img class="img-bill" style="width: 130px; height: 140px;"
                                    src="{{ asset('image/logo/'.Helper::GeneralSiteSettings('logo'))  }}" /> </div>
                            <br />
                            <h6>{{Helper::GeneralSiteSettings('name')}}</h6>
                            <p> س-ت : {{Helper::GeneralSiteSettings('section')}}<br>
                                {{Helper::GeneralSiteSettings('location')}}<br>
                                الجوال : {{Helper::GeneralSiteSettings('phone')}}<br>
                                البريد الإلكتروني:{{Helper::GeneralSiteSettings('email')}}</p>
                            رقم تعريف ضريبة القيمة المضافة :{{Helper::GeneralSiteSettings('vat_number')}}</p>
                        </div><!-- billed-from -->
                    </div><!-- invoice-header -->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mg-b-0 text-md-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="font-size:14px">متسلسل</th>
                                                <th style="font-size:14px">رقم القيد</th>
                                                <th style="font-size:14px">من حساب</th>
                                                <th style="font-size:14px">الى حساب </th>
                                                <th style="font-size:14px">المبلغ</th>
                                                <th style="font-size:14px">التاريخ</th>
                                                <th style="font-size:14px">البيان</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <span>{{$item->agent->tree4_code}}</span> --}}

                                            {{-- @livewire('model' ,['item_id' => $item->agent->tree4_code]) --}}
                                            @foreach ($Madin as $one)
                                            <tr>
                                                <th scope="row">{{$id++}}</th>
                                                <td>{{$one->Constraint_number}}</td>
                                                {{--  <td>
                                                    @isset($one->Dains->tree4_name)
                                                    {{$one->Dains->tree4_name}}
                                                    @endisset
                                                </td>  --}}

                                                <td>{{$one->Madins->tree4_name}}</td>
                                                <td>{{ number_format($one->price , 2)}} جنيه</td>
                                                <td>{{$one->date}}</td>
                                                <td>{{$one->Statement}}</td>
                                            </tr>
                                            @endforeach
                                            @foreach ($Dain as $one)
                                            <tr>
                                                <th scope="row">{{$id++}}</th>
                                                <td>{{$one->Constraint_number}}</td>
                                                <td>@isset($one->Dains->tree4_name)
                                                    {{$one->Dains->tree4_name}}
                                                    @endisset</td>
                                                <td>
                                                    @isset($one->Madins->tree4_name)
                                                    {{$one->Madins->tree4_name}}
                                                    @endisset
                                                </td>

                                                <td>{{ number_format($one->price , 2)}} جنيه </td>
                                                <td>{{$one->date}}</td>
                                                <td>{{$one->Statement}}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div><!-- bd -->

                            </div><!-- bd -->
                        </div><!-- bd -->
                    </div>
                    <div class="col-xl-12">
                        <div class="card mg-b-20">
                            <div class="card-body">
                                <span></span>
                                <div class="table-responsive">
                                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="font-size:14px">إجمالي المدين</th>
                                                <th style="font-size:14px">إجمالي الدائن</th>
                                                <th style="font-size:14px"> الرصيد</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <div style="display:none">
                                                <?php
                                        $Total_debtor=0;
                                        $Total_Creditor=0;
                                        $paid_up=0;
                                    ?>

                                                @foreach ($Madin as $one)
                                                {{$Total_debtor = $one->price + $Total_debtor}}
                                                @endforeach

                                                @foreach ($Dain as $two)
                                                {{$Total_Creditor = $two->price + $Total_Creditor}}
                                                {{$paid_up = $two->price + $paid_up}}
                                                @endforeach


                                            </div>
                                            <tr>
                                                <td>{{ number_format($Total_debtor, 2)}} جنيه</td>
                                                <td style="color:green">{{ number_format($paid_up , 2)}} جنيه</td>
                                                <td>{{ number_format($Total_Creditor - $Total_debtor , 2)}} جنيه</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mg-b-40">
                    {{-- <a class="btn btn-purple float-left mt-3 mr-2" href="">
                        <i class="mdi mdi-currency-usd ml-1"></i>Pay Now
                    </a> --}}
                    <button class="btn btn-primary float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                        <i class="mdi mdi-printer ml-1"></i> طبـاعة </button>
                    {{-- <a href="#" class="btn btn-success float-left mt-3">
                        <i class="mdi mdi-telegram ml-1"></i>Send Invoice
                    </a> --}}
                </div>
            </div>
        </div>
    </div><!-- COL-END -->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<script>
    function printDiv() {
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

</script>
@endsection
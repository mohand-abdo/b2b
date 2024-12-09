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
                <h4 class="content-title mb-0 my-auto">تقارير الفواتير </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تقرير مبيعات الاصناف </span>
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
                            <h1 class="invoice-title"> تقرير مبيعات حسب العميل : {{ $name }} <span></span>
                                <div class="col-md">
                                    <p><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p>
                                    <p><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p>
                                    {{-- <p><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p> --}}
                                    <p class="invoice-info-row" style="font-size: 14px"><span>تاريخ البداية :</span>
                                        {{ $start }}<span></span></p>
                                    <p class="invoice-info-row" style="font-size: 14px"><span>تاريخ النهاية :</span>
                                        {{ $end }}<span></span></p>
                                </div>
                            </h1>
                            <div class="billed-from">
                                <div class="col"> <img class="img-bill" style="width: 240px; height: 240px;"
                                        src="{{ asset('image/logo/' . Helper::GeneralSiteSettings('logo')) }}" /> </div>
                                <br />
                                {{--  <h5> {{Helper::GeneralSiteSettings('location')}} </h5< /br>  --}}
                                <h5>{{ Helper::GeneralSiteSettings('name') }}</h5>
                                <p>
                                    هاتف : {{ Helper::GeneralSiteSettings('phone') }}</br>
                                    البريد الإلكتروني:{{ Helper::GeneralSiteSettings('email') }}</p>
                            </div><!-- billed-from -->

                        </div><!-- invoice-header -->
                        {{-- show invoices detiales --}}
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                </div>
                                @foreach ($invoices as $invoice)
                                    <div class="card-body">
                                        <div><span>فاتورة رقم : </span> <span>{{ $invoice->invoice_number }}</span>
                                            &nbsp;<span>العميل : </span>{{ $invoice->tree4->tree4_name }}</div>
                                        </br>
                                        <div class="table-responsive">
                                            <table class="table table-invoice border text-md-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>متسلسل</th>
                                                        <th>الصنف</th>
                                                        <th>الوحدة</th>
                                                        <th>الكمية</th>
                                                        <th>سعر الوحدة</th>
                                                        <th>الاجمالي</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($invoice->sales as $item)
                                                        <tr>
                                                            <th scope="row">{{ $id++ }}</th>
                                                            <td>{{ $item->component }}</td>
                                                            <td>{{ $item->unit }}</td>
                                                            <td>{{ $item->amount }}</td>
                                                            <td>{{ number_format((int) $item->price) }}</td>
                                                            <td>{{ number_format((int) $item->price * (int) $item->amount) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- show total invoices in this date --}}
                        <table class="table table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th>الإجمالي </th>
                                    <th>الإجمالي (شامل الضريبة)</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ number_format($total, 2) }} ريال</td>
                                    <td>{{ number_format($endtotal, 2) }} ريال</td>

                                </tr>
                            </tbody>
                        </table>
                        </br>
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-primary" role="alert" style="text-align: center">
                                    <h4>مرحبـــاً بـك</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        {{--  //footer the page invoices  --}}
                        <div class="row">
                            <div class="col">
                                <h6 style="text-align: center">
                                    <span> {{ Helper::GeneralSiteSettings('location') }}
                                        - البريد الإلكتروني : {{ Helper::GeneralSiteSettings('email') }}
                                        - هاتف : {{ Helper::GeneralSiteSettings('phone') }}
                                    </span>
                                    </br>
                                </h6>
                            </div>
                        </div>
                        {{--  //footer the page invoices  --}}
                        <hr class="mg-b-40">
                        <button class="btn btn-primary float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                            <i class="mdi mdi-printer ml-1"></i> طبـاعة </button>
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
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
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

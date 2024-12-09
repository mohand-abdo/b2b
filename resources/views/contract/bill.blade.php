@extends('layouts.master')
<title> Contract - {{ now() }}</title>
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
                <h4 class="content-title mb-0 my-auto">إدارة العقودات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    عقودات الحجاج </span>
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

                            <h1 class="invoice-title">عقودات الحجاج <span></span>
                                <div class="col-md">
                                    <p><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p>
                                    <p><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p>
                                    {{-- <p><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p> --}}
                                    <p class="invoice-info-row" style="font-size: 14px"><span>تاريخ العقد :</span>
                                        {{$contract->contract_date}}<span></span></p>
                                    <p class="invoice-info-row" style="font-size: 14px"><span> &nbsp;</span>
                                        &nbsp;<span></span></p>
                                </div>
                            </h1>
                            <div class="billed-from">
                                <div class="col"> <img class="img-bill" style="width: 240px; height: 240px;"
                                        src="{{ asset('image/logo/' . Helper::GeneralSiteSettings('logo')) }}" /> </div>
                                <br />
                                <h5>{{ Helper::GeneralSiteSettings('name') }}</h5>
                                <p>
                                    هاتف : {{ Helper::GeneralSiteSettings('phone') }}</br>
                                    البريد الإلكتروني:{{ Helper::GeneralSiteSettings('email') }}</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row">
                        </div>
                        <br>
                        <div class="row mg-t-20">
                            <div class="col-md-12">
                                <label class="tx-gray-600">&nbsp;</label>
                                <table class="table table-bordered mg-b-0 text-md-nowrap print-table">
                                    <tbody>
                                        <tr style="background:#949eb7; font-size:22px;">
                                            <td style="text-align:center;">الرقم </td>
                                            <td style="text-align:center;"> الحاج /  المعتمر </td>
                                             <td style="text-align:center;"> الجنسية</td>
                                            <td style="text-align:center;"> الحملة </td>
                                            <td style="text-align:center;"> الضريبة </td>
                                            <td style="text-align:center;"> المبلغ شامل بالضريبة </td>
                                        </tr>
                                        <tr>

                                            <td style="text-align:center;">{{ $contract->id }}</td>
                                            <td style="text-align:center;">{{ $contract->tree4->tree4_name }}</td>
                                            <td style="text-align:center;">{{ $contract->tree4->nationalty }}</td>
                                            <td style="text-align:center;">{{ $contract->Campaign->name }}</td>

                                            <td style="text-align:center;">{{ $contract->tax }} %</td>
                                            <td style="text-align:center;">{{ $contract->total_amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <div class="col-md-12">
                                <label class="tx-gray-600">&nbsp;</label>
                                <table class="table table-bordered mg-b-0 text-md-nowrap">
                                    <tbody>
                                        <tr style="background:#949eb7; font-size:22px;">
                                            {{-- <td style="text-align:center;"> الملاحظـات </td> --}}
                                            <td style="text-align:center;"> شروط العقد</td>

                                        </tr>
                                        <tr>

                                            {{-- <td style="text-align:center;">sdfsd</td> --}}
                                            <td style="text-align:center;" style="text-align:center;">
                                                {!! $contract->contract_terms !!}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class="col">
                                <div style="text-align: center">
                                    <h4> ملاحظة هامة</h4>
                                    <span> في حالة عدم تطابق بيانات الحاج مع الاثبات ، نحن غير مسؤلين .. وهذا تعهد
                                        منا بذالك <br> {{ Helper::GeneralSiteSettings('name') }}</span>
                                </div>
                            </div>
                        </div>
                        <br>


                        <br>
                        <div class="row">
                            <div class="col">
                                <h5 style="text-align: center; font-size:16px" class="alert alert-secondary" role="alert">
                                    <span> {{ Helper::GeneralSiteSettings('location') }}
                                        - البريد الإلكتروني : {{ Helper::GeneralSiteSettings('email') }}
                                        - هاتف : {{ Helper::GeneralSiteSettings('phone') }}
                                    </span>


                                    </h6>
                            </div>
                        </div>
                        {{-- //footer the page invoices --}}
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

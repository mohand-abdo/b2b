@extends('layouts.master')

@section('css')
    <!-- Owl-carousel css -->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    &nbsp;
    <!-- /breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row row-sm">
        <!-- Card for Assets -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <h4 class="mb-3 tx-12 text-white"><i class="fa fa-kaaba"></i> عدد حملات الحج والعمرة </h4>
                    <div class="d-flex">
                        <div class="">
                            @php
                                $total_campaigns = \App\Models\Campaigns::count(); // حساب عدد الحملات
                            @endphp
                            <p class="tx-16 font-weight-bold mb-1 text-white">
                                عدد الحملات : {{ $total_campaigns }}
                            </p>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <!-- Card for Liabilities -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <h4 class="mb-3 tx-12 text-white"><i class="fas fa-mosque"></i>
                        عدد الحجاج</h4>
                    <div class="d-flex">
                        <div class="">
                            @php
                                $pilgrims_count = \App\Models\Tree4::where('tree3_code', 1205)->count();
                            @endphp
                            <p class="tx-16 font-weight-bold mb-1 text-white">
                                عدد الحجاج : {{ $pilgrims_count }}
                            </p>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <!-- Card for Revenues -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <h4 class="mb-3 tx-12 text-white"><i class="fas fa-file-signature"></i>
                        عدد عقودات الحج</h4>
                    <div class="d-flex">
                        <div class="">
                            @php
                                $contracts_count = \App\Models\Contract::count();
                            @endphp
                            <p class="tx-16 font-weight-bold mb-1 text-white">
                                عدد العقودات : {{ $contracts_count }}
                            </p>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
        <!-- Card for Expenses -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <h4 class="mb-3 tx-12 text-white"><i class="fas fa-coins"></i>
                        إجمالي مبلغ العقود</h4>
                    <div class="d-flex">
                        <div class="">
                            @php
                                $total_amount = \App\Models\Contract::sum('total_amount');
                                $formatted_amount = number_format($total_amount, 2);
                            @endphp
                            <p class="tx-14 font-weight-bold mb-1 text-white">
                                إجمالى المبالغ : {{ $formatted_amount }}
                            </p>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>

    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <!-- Chart for Cash Box -->
        <div class="col-md-6 col-lg-12 col-xl-6">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <h4 class="card-title mb-0">   إحصائية توضح تفاصيل حساب النقدية بالخزن </h4>
                </div>
                <div class="card-body" style="width: 98%">
                    {!! $chartjs->render() !!}
                </div>
            </div>
        </div>

        <!-- Chart for Bank Cash -->
        <div class="col-md-6 col-lg-12 col-xl-6">
            <div class="card card-dashboard-map-one">
                <h4 class="card-title mb-0">إحصائية توضح إجمالى الحملات النشطة والغير نشطة</h4>
                <div style="width: 102.5%">
                    {!! $chartjs_2->render() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- row closed -->
@endsection

@section('js')
    <!-- Internal Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <!-- Internal Flot js -->
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <!-- Internal Apexchart js -->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
    <!-- Internal index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
@endsection

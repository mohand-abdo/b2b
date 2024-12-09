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
            <h4 class="content-title mb-0 my-auto">الحسابات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ كشف حساب
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
                        <h1 class="invoice-title">تقرير قيد يومية  <span></span>
                            <div class="col-md">
                                <p ><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p>
                                <p ><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p>
                                {{--  <p ><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p>  --}}
                                <p class="invoice-info-row" style="font-size: 14px"><span> التاريخ :</span> <?php echo date('Y-m-d'); ?><span></span></p>
                                <p class="invoice-info-row" style="font-size: 14px"><span>  &nbsp;</span>&nbsp;<span></span></p> 
                            </div></h1>
                        <div class="billed-from">
                            <div class="col"> <img class="img-bill" style="width: 130px; height: 140px;"
                                    src="{{ asset('image/logo/'.Helper::GeneralSiteSettings('logo'))  }}" /> </div>
                            <br />
                            <h5> {{Helper::GeneralSiteSettings('location')}} </h5< /br>
                                <h5>{{Helper::GeneralSiteSettings('name')}}</h5>
                                <p>
                                <h6>مسجلة بالمركز الوطني لتنمية القطاع غير الربحي برقم :
                                    ({{Helper::GeneralSiteSettings('section')}})</br></h6>
                                هاتف : {{Helper::GeneralSiteSettings('phone')}}</br>
                                البريد الإلكتروني:{{Helper::GeneralSiteSettings('email')}}</p>
                                الرمز البريدي : {{Helper::GeneralSiteSettings('vat_number')}}</p>
                        </div><!-- billed-from -->
                    </div><!-- invoice-header -->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mg-b-0 text-md-nowrap">
                                        <thead>
                                            <thead>
                                                <tr>
                                                    {{-- <th>متسلسل</th> --}}
                                                    <th> الحساب الدائن</th>
                                                    <th> الحساب المدين</th>
                                                    <th>  المبلغ</th>
                                                    <th>تاريخ الأنشاء</th>
                                                    <th>أنشأ بواسطة</th>
                                                    <th> البيان</th>
                                                    <th>رقم القيد</th>
                                                    <th>تاريخ القيد</th>

                                                </tr>
                                            </thead>
                                        <tbody>
                                            {{-- @foreach ($daily as $one ) --}}


                                            <tr>
                                                <td>{{$daily->Dains->tree4_name}}</td>
                                                <td>{{$daily->Madins->tree4_name}}</td>
                                                <td>{{$daily->price}}</td>
                                                <td>{{$daily->created_at}}</td>
                                                <td>{{$daily->user->name}}</td>
                                                <td>{{$daily->Statement}}</td>
                                                <td>{{$daily->Constraint_number}}</td>
                                                <td>{{$daily->date}}</td>
                                            </tr>
                                            {{-- @endforeach --}}
                                        </tbody>
                                    </table>
                                </div><!-- bd -->

                            </div><!-- bd -->
                        </div><!-- bd -->
                    </div>
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
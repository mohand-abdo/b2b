@extends('layouts.master')
<title> Receipt - {{$bill->Constraint_number}} - {{now()}}</title>
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
            <h4 class="content-title mb-0 my-auto">إدارة العملاء </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                  سندات القبض </span>
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
                        <h1 class="invoice-title"> سند قبض نقدي 
                            <div class="col-md">
                                <p><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p>
                                <p><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p>
                                {{-- <p><span> &nbsp;</span>&nbsp; <span>&nbsp;</span></p> --}}
                                <p class="invoice-info-row" style="font-size: 14px"><span>رقم القيد  :</span>
                                    {{$bill->Constraint_number}}<span></span></p>
                                <p class="invoice-info-row" style="font-size: 14px"><span>تاريخ القيد :</span>
                                    {{$bill->date}}<span></span></p>
                            </div>
                        </h1>
                        <div class="billed-from">
                            <div class="col"> <img class="img-bill" style="width: 260px; height: 200px;"
                                    src="{{ asset('image/logo/'.Helper::GeneralSiteSettings('logo'))  }}" /> </div>
                            <br />
                            {{--  <h5> {{Helper::GeneralSiteSettings('location')}} </h5< /br>  --}}
                                <h5>{{Helper::GeneralSiteSettings('name')}}</h5>
                                <p>
                                 <h6> س.ت  :
                                    {{Helper::GeneralSiteSettings('section')}}</br>
                                   {{--  {{Helper::GeneralSiteSettings('location')}}</br>  --}}
                               هاتف : {{Helper::GeneralSiteSettings('phone')}}</br>
                                البريد الإلكتروني : {{Helper::GeneralSiteSettings('email')}}</p>
                                رقم تعريف ضريبة القيمة المضافة  : {{Helper::GeneralSiteSettings('vat_number')}}</p></h6>
                        </div><!-- billed-from -->
                    </div><!-- invoice-header -->
                  
                    <div  class="table-responsive mg-t-40">
                        <table class="table table-invoice border text-md-nowrap mb-0">
                            <tbody>
                                <tr>
                    
                                    <td class="tx-right">   استلمنا من السيد / السادة  : </td>
                                    <td class="tx-right" colspan="2">{{$bill->Dains->tree4_name}}</td>
                                </tr>

                                <tr>
                                    <td class="tx-right">   مبلغاً وقدرة : </td>
                                    <td class="tx-right" colspan="2">{{number_format($bill->price,2)}} SAR</td>
                                </tr>

                                </tr>
                                <tr>
                                    <td class="tx-right"> علي حساب   : </td>
                                    <td class="tx-right" colspan="2"> {{$bill->Madins->tree4_name}} </td>
                                </tr>
                                <tr>
                                    <td class="tx-right"> المبلغ كتبابة : </td>
                                    <td class="tx-right" colspan="2">{{$numberTransformer->toWords($bill->price); }} ريال</td>
                                </tr>
                               
                                <tr>
                                    <td class="tx-right">إسم المستلم : </td>
                                    <td class="tx-right" colspan="2">{{$bill->user->name}}</td>
                                </tr>

                                <tr>
                                    <td class="tx-right">   ملاحظات   : </td>
                                    <td class="tx-right" colspan="2"> {{$bill->Statement}} </td>
                                </tr>
                                {{--  <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي ( بما في ذلك ضريبة القيمة المضافة) </td>
                                    <td class="tx-right" colspan="2">
                                        <h4 class="tx-primary tx-bold"> 345 SAR</h4>
                                    </td>
                                </tr>  --}}
                            </tbody>
                        </table>
                    </div>
                </br>


                <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br>
                <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br>

                    <div class="row">
                        <div class="col">
                          <div class="alert alert-primary" role="alert" style="text-align: center">
                              <h4>شكراً لزيارتكم</h4>
                              <span></span>
                          </div>
                           </div>
                      </div>
                   {{--  //footer the page invoices  --}}
                   <div class="row">
                    <div class="col">
                        <h6 style="text-align: center">
                            <span> {{Helper::GeneralSiteSettings('location')}}
                                - البريد الإلكتروني : {{Helper::GeneralSiteSettings('email')}}
                                - هاتف : {{Helper::GeneralSiteSettings('phone')}}
                            </span>

                            </br>
                        </h6>
                        <h6 style="text-align: center">
                            <span>
                                حساب بنك الراجحي : {{Helper::GeneralSiteSettings('r_bank')}} -
                                الايبان : {{Helper::GeneralSiteSettings('r_iban')}} -
                                حساب البنك الأهلي : {{Helper::GeneralSiteSettings('a_bank')}} -
                                الايبان : {{Helper::GeneralSiteSettings('a_iban')}}
                            </span>
                        </h6>
                    </div>
                </div>
                 <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br> <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br> <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br> <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br> <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br> <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br>
                <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br>
                <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br>
                <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br>
                <div class="row">
                    <div class="col">
                        <h6>
                            &nbsp;
                        </h6>
                    </div>
                  </div>
                </br>
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
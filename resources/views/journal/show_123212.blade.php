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
            <h4 class="content-title mb-0 my-auto">الحسابات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/  كشف حساب </span>
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
                        <h1 class="invoice-title">فاتورة ضريبية <span>INV-0079</span></h1>
                        <div class="billed-from">
                          <div class="col"> <img class="img-bill" style="width: 130px; height: 140px;"
                                src="{{ asset('image/logo/'.Helper::GeneralSiteSettings('logo'))  }}" /> </div> <br />
                            <h6>{{Helper::GeneralSiteSettings('name')}}</h6>
                               <p> س-ت : {{Helper::GeneralSiteSettings('section')}}<br>
                                            {{Helper::GeneralSiteSettings('location')}}<br>
                               الجوال :    {{Helper::GeneralSiteSettings('phone')}}<br>
                                البريد الإلكتروني:{{Helper::GeneralSiteSettings('email')}}</p>
                                 رقم تعريف ضريبة القيمة المضافة :{{Helper::GeneralSiteSettings('vat_number')}}</p>
                        </div><!-- billed-from -->
                    </div><!-- invoice-header -->
                    <div class="row mg-t-20">
                        <div class="col-md">
                            <label class="tx-gray-600">Billed To</label>
                            <div class="billed-to">
                                <h6>Juan Dela Cruz</h6>
                                <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                    Tel No: 324 445-4544<br>
                                    Email: youremail@companyname.com</p>
                            </div>
                        </div>
                        <div class="col-md">
                            <label class="tx-gray-600">معلومات الفاتورة </label>
                            <p class="invoice-info-row"><span>رقم الفاتورة :</span> <span>{{$invoices->invoice_number}}</span></p>
                            <p class="invoice-info-row"><span>تاريخ الإصدار :</span> <span>{{$invoices->invoice_Date}}</span></p>
                            <p class="invoice-info-row"><span> تاريخ الاستحقاق :</span> <span>{{$invoices->Due_date}}</span></p>
                            {{-- <p class="invoice-info-row"><span>Due Date:</span> <span>November 30, 2017</span></p>  --}}
                        </div>
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-invoice border text-md-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th class="wd-20p">#</th>
                                    <th class="wd-40p">المنتج او الخدمة</th>
                                    <th class="tx-center">مبلغ التحصيل </th>
                                    <th class="tx-right">الخصم </th>
                                    <th class="tx-right">الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Website Design</td>
                                    {{-- (number fromat)  تستخدم دالة لوضغ الفواصل في الارقام لتحديد المبلغ  --}}
                                    <td class="tx-12">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam...</td>
                                    <td class="tx-center">{{ number_format($invoices->Amount_collection,2) }}</td>
                                    <td class="tx-right">{{ number_format($invoices->Discount,2) }}</td>
                                    <td class="tx-right">{{ number_format($invoices->Total,2) }}</td>
                                </tr>
                                <tr>
                                    <td>Firefox Plugin</td>
                                    <td class="tx-12">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque...</td>
                                    <td class="tx-center">1</td>
                                    <td class="tx-right">$1,200.00</td>
                                    <td class="tx-right">$1,200.00</td>
                                </tr>
                                <tr>
                                    <td>iPhone App</td>
                                    <td class="tx-12">Et harum quidem rerum facilis est et expedita distinctio</td>
                                    <td class="tx-center">2</td>
                                    <td class="tx-right">$850.00</td>
                                    <td class="tx-right">$1,700.00</td>
                                </tr>
                                <tr>
                                    <td>Android App</td>
                                    <td class="tx-12">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut</td>
                                    <td class="tx-center">3</td>
                                    <td class="tx-right">$850.00</td>
                                    <td class="tx-right">$2,550.00</td>
                                </tr>
                                <tr>
                                    <td class="valign-middle" colspan="2" rowspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13">Notes</label>
                                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                        </div><!-- invoice-notes -->
                                    </td>
                                    <td class="tx-right">الإجمالي (غير شامل الضريبة)</td>
                                    <td class="tx-right" colspan="2">$5,750.00</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">نسبة الضريبة (5%)</td>
                                    <td class="tx-right" colspan="2">$287.50</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">الخصم</td>
                                    <td class="tx-right" colspan="2">-$50.00</td>
                                </tr>
                                <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي (شامل الضريبة) </td>
                                    <td class="tx-right" colspan="2">
                                        <h4 class="tx-primary tx-bold">$5,987.50</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="mg-b-40">
                    {{-- <a class="btn btn-purple float-left mt-3 mr-2" href="">
										<i class="mdi mdi-currency-usd ml-1"></i>Pay Now
									</a>  --}}
                    <button class="btn btn-primary float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                        <i class="mdi mdi-printer ml-1"></i> طبـاعة الفاتورة </button>
                    {{-- <a href="#" class="btn btn-success float-left mt-3">
										<i class="mdi mdi-telegram ml-1"></i>Send Invoice
									</a>  --}}
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

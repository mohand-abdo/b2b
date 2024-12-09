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
        <div class="d-flex">
            <a class="btn btn-primary float-left mt-3 mr-2" href="{{ url('/' . $page='client_statement') }}" >
                <i class="far fa-arrow-alt-circle-right"></i> رجوع  </a>

				 <button class="btn btn-primary float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                <i class="mdi mdi-printer ml-1"></i> طبـاعة التقرير </button>
            {{-- <h4 class="content-title mb-0 my-auto">Tables</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Basic Tables</span>  --}}
        </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!--div-->
<div id="print" >
<div class="col-xl-12" >
    <div class="card mg-b-20">
        <div class="card-body">
		<span></span>
            <div class="table-responsive">
                <table class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead>
                        <tr>
                            <th  style="font-size:14px">إجمالي المدين</th>
                            <th  style="font-size:14px">إجمالي الدائن</th>
                            <th  style="font-size:14px"> إجمالي المتبقي</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div style ="display:none">
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
                            <td style="color:red">{{ number_format($Total_debtor - $Total_Creditor , 2)}} جنيه</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--/div-->
<!--div-->
<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mg-b-0 text-md-nowrap">
                    <thead>
                        <tr>
                            <th  style="font-size:14px">متسلسل</th>
                            <th  style="font-size:14px">رقم القيد</th>
                            <th  style="font-size:14px">من حساب</th>
                            <th  style="font-size:14px">الى حساب </th>
                            <th  style="font-size:14px">المبلغ</th>
                            <th  style="font-size:14px">التاريخ</th>
                            <th  style="font-size:14px">البيان</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <span>{{$item->agent->tree4_code}}</span> --}}

                        {{-- @livewire('model' ,['item_id' => $item->agent->tree4_code]) --}}
                        @foreach ($Madin as $one)
                        <tr>
                            <th scope="row">{{$id++}}</th>
                            <td>{{$one->Constraint_number}}</td>
                            <td>
                                @isset($one->Dains->tree4_name)
                                {{$one->Dains->tree4_name}}
                                @endisset
                            </td>

                            <td>{{$one->Madins->tree4_name}}</td>
                            <td>{{ number_format($one->price  , 2)}} جنيه</td>
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

                            <td>{{ number_format($one->price  , 2)}} جنيه </td>
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
</div> 
{{--  div print  --}}
<!--/div-->
</div>
<!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
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

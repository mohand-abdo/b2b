@extends('layouts.master2')
@section('css')
<!--- Internal Fontawesome css-->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!---Ionicons css-->
<link href="{{URL::asset('assets/plugins/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
<!---Internal Typicons css-->
<link href="{{URL::asset('assets/plugins/typicons.font/typicons.css')}}" rel="stylesheet">
<!---Internal Feather css-->
<link href="{{URL::asset('assets/plugins/feather/feather.css')}}" rel="stylesheet">
<!---Internal Falg-icons css-->
<link href="{{URL::asset('assets/plugins/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<!-- Main-error-wrapper -->
<div class="main-error-wrapper  page page-h ">
    <img style="width: 150px; height: 150px;" src="{{ asset('image/logo/'.Helper::GeneralSiteTransportSettings('logo'))  }}"
        class="error-page" alt="error">
    <br>
    <div class="row">
        <div class="col">
            <div class="alert alert-primary" role="alert">
                {{Helper::GeneralSiteTransportSettings('name')}}</br>
                هاتف : {{Helper::GeneralSiteTransportSettings('phone')}}</br>
                البريد الإلكتروني : {{Helper::GeneralSiteTransportSettings('email')}}</p>
                {{--  رقم تعريف ضريبة القيمة المضافة : {{Helper::GeneralSiteTransportSettings('vat_number')}}</p>  --}}
                </h6>
            </div>
            <div class="alert alert-primary" role="alert">
              <h2> مرحبـــاً بـك  </h2>  
            </div>
            <div class="alert alert-primary" role="alert">
                   عقد نقل صحيح بالرقم  : {{$invoices->number ?? '-'}}

            </div>
            <div class="alert alert-primary" role="alert">
                التاريخ  : {{$invoices->date}}

            </div>
            <div class="alert alert-primary" role="alert">
               السيارة : {{$invoices->cars->type}}

            </div>
            <div class="alert alert-primary" role="alert">
               الرحلة  من  : {{$invoices->froms->name}} 

            </div>
            <div class="alert alert-primary" role="alert">
                الي :  {{$invoices->tos->name}}

            </div>
        </div>
    </div>
</div>
<!-- /Main-error-wrapper -->
@endsection
@section('js')
@endsection
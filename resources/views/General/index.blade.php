@extends('layouts.master')
@section('css')
<!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    {{-- select2  --}}
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@livewireStyles
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto"> إدارة الحسابات </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ كشف عام للحسابات</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex">
                    <h5 class="content-title mb-0 my-auto">كشف حساب :</h5>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="card-body">
                        <form method="POST" action="{{route('General.show')}}" id="demo-form2" class="form-horizontal form-label-left">
                            @csrf
                            </br>
                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label"> تاريخ البداية
                                        <span class="required">*</span>
                                    </label>
                                    <input type="date" name="start" value="<?php echo date('Y-m-d'); ?>" class="form-control" required>
                                </div>
                                </br>
                                <div class="col">
                                    <label for="inputName" class="control-label"> تاريخ النهاية
                                        <span class="required">*</span>
                                    </label>
                                    <input type="date" name="end" value="<?php echo date('Y-m-d'); ?>" class="form-control" required>
                                </div>
                            </div>
                            </br>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary"> بحث</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--/div-->
    <!-- row closed -->
</div>
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@livewireScripts

@endsection

@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
    @livewireStyles
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto"> إدارة النظام المحاسبي </h5><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0"> / القيود المركبة</span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة قيد</span>
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
                    @if ($errors->any())
                        <div class="alert alert-outline-warning" role="alert">
                            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span></button>
                            @foreach ($errors->all() as $error)
                                <strong>خطأ!</strong> {{ $error }}
                            @endforeach
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: " تم إضافة القيد بنجاح",
                                    type: "success"
                                })
                            }
                        </script>
                    @endif
                    @if (session()->has('warning'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: "لم تتم عملية الادخال بالشكل الصحيح ",
                                    type: "warning"
                                })
                            }
                        </script>
                    @endif
                    @if (session()->has('delete'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: " تم حذف القيد بنجاح",
                                    type: "success"
                                })
                            }
                        </script>
                    @endif

                    <div class="d-flex">
                        <h5 class="content-title mb-0 my-auto"> إضاف قيد جديد :</h5>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="card-body">
                            <?php
                            $maxInvoiceNumber = DB::table('restrictions')->max('Constraint_number');
                            $nextInvoiceNumber = $maxInvoiceNumber + 1;
                            ?>
                            <form action="{{ route('Vehicle.store') }}" method="POST"
                                class="form-horizontal form-label-left">
                                @csrf
                                {{-- البيانات الاساسية للقيد --}}
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label"> رقم القيد</label>
                                        <input required type="text" value="{{ $nextInvoiceNumber }}" readonly
                                            name="Constraint_number" class="form-control" title="يرجي ادخال إسم الحساب"
                                            required>
                                    </div>
                                    <div class="col">
                                        <span class="tx-danger">*</span><label for="inputName" class="control-label"> تاريخ
                                            القيد</label>
                                        <input required type="date" name="date" value="<?php echo date('Y-m-d'); ?>"
                                            class="form-control" title="يرجي ادخال إسم الحساب" required>
                                    </div>
                                    <div class="col">
                                        <span class="tx-danger">*</span><label for="inputName" class="control-label"> بيان
                                            القيد</label>
                                        <input required type="text" name="Statement" class="form-control"
                                            title="يرجي ادخال  البيان" required>
                                    </div>
                                </div>

                                {{--  حقل الاجمالي مخفي للاستخدام في عملية إخفاء الزر  --}}
                                <div class="col">
                                    {{--  <label for="inputName" class="control-label"> الاجمالي </label>  --}}
                                    <input readonly type="hidden" id="all" class="form-control"
                                        title="يرجي ادخال  البيان" required>
                                </div>
                                {{--  حقل الاجمالي مخفي للاستخدام في عملية إخفاء الزر  --}}

                                {{-- البيانات الاساسية للقيد --}}
                                </br>
                                {{-- @livewire('select') --}}
                                {{-- الحساب الرئيسي الدائن --}}
                                {{-- first row in the mult restraction --}}
                                <div class="row">
                                    <div class="col">
                                        <span class="tx-danger">*</span><label>الحساب الدائن</label>
                                        <select required name="account_one" class="form-control select2-from"></select>
                                    </div>
                                    <div class="col">
                                        <span class="tx-danger">*</span><label for="inputName" class="control-label">
                                            المبلغ</label>
                                        <input required id="one" onkeyup="vat()" type="number" name="price_one"
                                            class="form-control" title="يرجي ادخال  المبلغ" required>
                                    </div>
                                </div>
                                </br>
                                {{-- first row in the mult restraction --}}
                                {{-- الحساب الرئيسي الدائن --}}

                                {{-- الحساب الفرعية المدينة --}}
                                {{-- tow row in the mult restraction --}}
                                <div class="row">
                                    <div class="col">
                                        {{-- <label>الحساب</label> --}}
                                        <select required name="account_tow" style="width: 100%"  class="form-control select2-to"></select>
                                    </div>
                                    <div class="col">
                                        {{-- <label for="inputName" class="control-label"> المبلغ</label> --}}
                                        <input required type="number" id="tow" value="0" name="price_tow"
                                            onkeyup="vat()" class="form-control" title="يرجي ادخال  المبلغ" required>
                                    </div>
                                </div>
                                {{-- tow row in the mult restraction --}}
                                </br>
                                {{-- tow row in the mult restraction --}}
                                <div class="row">
                                    <div class="col">
                                        {{-- <label>الحساب</label> --}}
                                        <select name="account_three" style="width: 100%" class="form-control select2-to"></select>
                                    </div>
                                    <div class="col">
                                        {{-- <label for="inputName" class="control-label"> المبلغ</label> --}}
                                        <input required type="number" id="three" onkeyup="vat()" value="0"
                                            name="price_three" class="form-control" title="يرجي ادخال  المبلغ">
                                    </div>
                                </div>
                                {{-- tow row in the mult restraction --}}
                                </br>
                                {{-- four row in the mult restraction --}}
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <ul id="treeview1">
                                            <li><a href="#">اَخـري</a>
                                                <ul>
                                                    <div class="col-md-6">
                                                        {{-- <label>الحساب</label> --}}
                                                        <select name="account_four"
                                                            style="width: 100%"  class="form-control select2-to"></select>
                                                    </div>
                                                </ul>
                                                &nbsp;
                                                <ul>
                                                    <div class="col-md-6">
                                                        {{-- <label for="inputName" class="control-label"> المبلغ</label>
                                                    --}}
                                                        <input type="number" onkeyup="vat()" id="four"
                                                            value="0" name="price_four" class="form-control"
                                                            title="يرجي ادخال  المبلغ">
                                                    </div>
                                                </ul>
                                                &nbsp;
                                                <ul>
                                                    <div class="col-md-6">
                                                        {{-- <label>الحساب</label> --}}
                                                        <select name="account_five"
                                                            style="width: 100%" class="form-control select2-to"></select>
                                                    </div>
                                                </ul>
                                                &nbsp;
                                                <ul>
                                                    <div class="col-md-6">
                                                        {{-- <label for="inputName" class="control-label"> المبلغ</label>
                                                    --}}
                                                        <input type="number" onkeyup="vat()" id="five"
                                                            value="0" name="price_five" class="form-control"
                                                            title="يرجي ادخال  المبلغ">
                                                    </div>
                                                </ul>
                                                &nbsp;
                                                <ul>
                                                    <div class="col-md-6">
                                                        {{-- <label>الحساب</label> --}}
                                                        <select name="account_six"
                                                            class="form-control select2-to" style="width: 100%"></select>
                                                    </div>
                                                </ul>
                                                &nbsp;
                                                <ul>
                                                    <div class="col-md-6">
                                                        {{-- <label for="inputName" class="control-label"> المبلغ</label>
                                                    --}}
                                                        <input type="number" onkeyup="vat()" id="six"
                                                            value="0" name="price_six" class="form-control"
                                                            title="يرجي ادخال  المبلغ">
                                                    </div>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                {{-- three row in the mult restraction --}}
                                {{-- الحساب الفرعية المدينة --}}
                                </br>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" id="saveButton" class="btn btn-primary"> إضــافة
                                        القيد</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
    <script>
        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var tree3_name = button.data('tree3_name')
            var tree4_code = button.data('tree4_code')
            var tree4_name = button.data('tree4_name')

            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #tree3_name').val(tree3_name);
            modal.find('.modal-body #tree4_code').val(tree4_code);
            modal.find('.modal-body #tree4_name').val(tree4_name);

        })
    </script>
    <script>
        $('#modaldemo5').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>

    <script>
        function vat() {
            var one = parseFloat($("#one").val());
            var tow = parseFloat($("#tow").val());
            var three = parseFloat($("#three").val());
            var four = parseFloat($("#four").val());
            var five = parseFloat($("#five").val());
            var six = parseFloat($("#six").val());
            var r = tow + three + four + five + six;
            parseFloat($("#all").val(r));
            if (parseFloat($("#all").val()) === parseFloat($("#one").val())) {
                $("#saveButton").prop('disabled', false);
            } else {
                $("#saveButton").prop('disabled', true);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // تهيئة الحقل "من حساب"
            $('.select2-from').select2({
                ajax: {
                    url: "{{ route('select2.getVehicle') }}", // رابط البحث
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // نص البحث
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true,
                },
                placeholder: 'يرجى اختيار الحساب من',
            });

            // تهيئة الحقل "إلى حساب"
            $('.select2-to').select2({
                ajax: {
                    url: "{{ route('select2.getVehicle') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // نص البحث
                            exclude: $('.select2-from')
                                .val() // إرسال القيمة المختارة في "من حساب" كـ exclude
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true,
                },
                placeholder: 'يرجى اختيار الحساب إلى',
            });

            // تحديث الحقل "إلى حساب" عند تغيير الحقل "من حساب"
            $('.select2-from').on('change', function() {
                $('.select2-to').val(null).trigger('change'); // إعادة تعيين الحقل "إلى حساب"
                $('.select2-to').prop('disabled', false);

            });

            $('.select2-to').on('change', function() {
                if ($('.select2-to').val() === $('.select2-from').val()) {
                    $('.select2-to').val(null).trigger('change'); // إعادة تعيين الحقل "إلى حساب"
                    notif({
                        msg: "لا يمكن ادخال حساب الى بنفس الحساب من.",
                        type: "error"
                    })
                }
            });
        });
    </script>

    @livewireScripts
@endsection

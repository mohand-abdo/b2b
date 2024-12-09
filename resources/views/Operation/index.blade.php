@extends('layouts.master')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet" />
@livewireStyles
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h5 class="content-title mb-0 my-auto"> إدارة النظام المحاسبي </h5><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ القيود اليومية</span>
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
                @if($errors->any())
                <div class="alert alert-outline-warning" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                    @foreach ($errors->all() as $error)
                    <strong>خطأ!</strong> {{$error}}
                    @endforeach
                </div>
                @endif
                @if (session()->has('success'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: " تم إضافة القيد بنجاح"
                            , type: "success"
                        })
                    }

                </script>
                @endif
                @if (session()->has('edit'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: " تم تحديث القيد بنجاح"
                            , type: "success"
                        })
                    }

                </script>
                @endif
                @if (session()->has('delete'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: " تم حذف القيد بنجاح"
                            , type: "success"
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
                        $nextInvoiceNumber =  $maxInvoiceNumber + 1;
                        ?>
                        <form action="{{route('Operation.store')}}" method="POST" class="form-horizontal form-label-left">
                            @csrf
                            <div class="col">
                                {{--  <label for="inputName" class="control-label"> رقم القيد</label>  --}}
                                <input required type="hidden" value="{{ $nextInvoiceNumber}}" name="Constraint_number"
                                    class="form-control" title="يرجي ادخال إسم الحساب" required>
                            </div>


                            @livewire('select')

                            </br>
                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label"> المبلغ</label>
                                    <input required type="number" name="price" class="form-control" title="يرجي ادخال إسم الحساب" required>
                                </div>
                                </br>
                                <div class="col">
                                    <label for="inputName" class="control-label"> التاريخ </label>
                                    <input required type="date" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" title="يرجي ادخال إسم الحساب" required>
                                </div>
                            </div>
                            </br>
                            <div class="row">
                                <div class="col">
                                    <label>البيان</label>
                                    <textarea rows="5" name="Statement" class="form-control"></textarea>
                                </div>
                            </div>
                            </br>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary"> إضــافة القيد</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        {{--  card table   --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    @if ($daily->count() > 0)
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th>متسلسل</th>
                                <th>رقم القيد</th>
                                <th>من حساب </th>
                                <th>الى حساب</th>
                                <th>المبلغ</th>
                                <th>البيان</th>
                                <th>تاريخ العملية</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($daily as $item)
                            <tr>
                                <th scope="row">{{$id++}}</th>
                                <td>{{$item->Constraint_number}}</td>
                                <td>
                                    @isset($item->Dains->tree4_name)
                                    {{$item->Dains->tree4_name}}
                                    @endisset
                                </td>

                                <td>
                                    @isset($item->Madins->tree4_name)
                                    {{$item->Madins->tree4_name}}
                                    @endisset
                                </td>


                                <td>{{number_format($item->price, 2)}}</td>
                                <td>{{$item->Statement}}</td>
                                <td>{{$item->date}}</td>
                                <td>
                                    {{-- <a class="modal-effect btn btn-outline-success btn-sm" data-effect="effect-super-scaled" data-toggle="modal" href="#modaldemo8" data-id="{{$tree->id}}" data-tree4_name="{{$tree->tree4_name}}" data-tree4_code="{{$tree->tree4_code}}" data-tree3_name="{{$tree->tree3->tree3_name}}" title="تعديل">
                                    <i class="fa fa-edit">
                                    </i>&nbsp;&nbsp;تعديل </i></a> --}}
                                    <a class="modal-effect btn btn-outline-danger btn-sm" data-target="#modaldemo5" data-toggle="modal" href="#modaldemo5" data-id="{{$item->id}}" title="تعديل"> <i class="fa fa-trash">
                                        </i>&nbsp;&nbsp;حذف </i></a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>لا يوجد قيود حاليا</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--/div-->

    <!-- row closed -->
</div>
{{-- // modal delete alert    --}}
<div class="modal" id="modaldemo5">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                <form action="Operation/destroy" method="post">
                    {{method_field('delete')}}
                    {{csrf_field()}}
                    <input type="hidden" id="id" name="id" class="form-control">
                    <h4 class="tx-danger mg-b-20">هل تريد حذف هذا السجل بالفعل ؟</h4>
                    <p class="mg-b-20 mg-x-20">في حالة الموافقة لا يمكنك التراجع عن هذا الاجراء !</p>
                    <button class="btn ripple btn-danger pd-x-25" type="submit">نعم , حذف السجل</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إلغاء</button>
                </form>
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
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
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
@livewireScripts

@endsection

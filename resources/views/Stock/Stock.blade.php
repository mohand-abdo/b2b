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
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المخزن</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة المخازن</span>
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
                    {{-- <strong>خطأ!</strong> {{session()->get('Erorr')}} --}}
                </div>
                @endif



                @if (session()->has('success'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: " تم حفط المخزن بنجاح"
                            , type: "success"
                        })
                    }

                </script>
                @endif

                @if (session()->has('edit'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: " تم تحديث المخزن بنجاح"
                            , type: "success"
                        })
                    }

                </script>
                @endif
                @if (session()->has('delete'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: " تم حذف المخزن بنجاح"
                            , type: "warning"
                        })
                    }

                </script>
                @endif

                <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">

                    <a class="modal-effect btn btn-primary btn-block" data-effect="effect-super-scaled" data-toggle="modal" href="#modaldemo8"><i class="fa fa-plus"> </i>&nbsp;&nbsp;إضافة مخزن جديد </i></a>

                </div>
                {{-- <p class="tx-12 tx-gray-500 mb-2">Example of Valex Simple Table. <a href="">Learn more</a></p>  --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">متسلسل</th>
                                <th class="wd-15p border-bottom-0">إسم المخزن </th>
                                <th class="wd-20p border-bottom-0">كود الحساب </th>
                                <th class="wd-15p border-bottom-0">العمليات </th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($tree4s as $tree)

                            <tr>
                                <td>{{$id++}}</td>
                                <td>{{$tree->tree4_name}}</td>
                                <td>{{$tree->tree4_code}}</td>
                                <td>
                                    <a class="modal-effect btn btn-outline-success btn-sm" data-effect="effect-super-scaled" data-toggle="modal" href="#modaldemo7" data-id="{{$tree->id}}" data-tree4_name="{{$tree->tree4_name}}" data-phone="{{$tree->phone}}" data-tree3_name="{{$tree->tree3->tree3_name}}" title="تعديل">
                                        <i class="fa fa-edit">
                                        </i>&nbsp;&nbsp;تعديل </i></a>
                                    <a class="modal-effect btn btn-outline-danger btn-sm" data-target="#modaldemo5" data-toggle="modal" href="#modaldemo5" data-id="{{$tree->id}}" data-tree4_name="{{$tree->tree4_name}}" data-tree4_code="{{$tree->tree4_code}}" data-tree3_name="{{$tree->tree3->tree3_name}}" title="حذف">
                                        <i class="fa fa-trash">
                                        </i>&nbsp;&nbsp;حذف </i></a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->



    {{-- //insert model super scale  --}}
    <!-- Basic modal -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">إضافة مخزن جديد </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{route('Stock.store')}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">إسم المخزن </label>
                            <input type="text" name="tree4_name" id="tree4_name" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">إضافة </button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Basic modal -->


    {{-- //edit model section   --}}
    <div class="modal" id="modaldemo7">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل اسم المخزن </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="Stock/update" method="post">
                    {{method_field('put')}}
                    {{csrf_field()}}
                    <div class="modal-body">

                        <div class="form-group">
                            <label>اسم المخزن</label>
                            <input id="id" required type="hidden" name="id" class="form-control">
                            <input id="tree4_name" required type="text" name="tree4_name" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">تحديث البيانات </button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
<!-- row closed -->
</div>
{{-- // modal delete alert    --}}
<div class="modal" id="modaldemo5">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                <form action="Stock/destroy" method="post">
                    {{method_field('delete')}}
                    {{csrf_field()}}
                    <input type="hidden" id="id" name="id" class="form-control">
                    <h4 class="tx-danger mg-b-20">هل تريد حذف هذا السجل بالفعل ؟</h4>
                    <input type="hidden" id="tree4_name" readonly name="tree4_name" class="form-control">
                    <p class="mg-b-20 mg-x-20">في حالة الموافقة لا يمكنك التراجع عن هذا الاجراء !</p>
                    <button class="btn ripple btn-danger pd-x-25" type="submit">نعم , حذف السجل</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إلغاء</button>
                </form>
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
{{-- modals  --}}
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

{{-- delete script  --}}
<script>
    $('#modaldemo7').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var tree3_name = button.data('tree3_name')
        var tree4_name = button.data('tree4_name')
        var phone = button.data('phone')

        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #tree3_name').val(tree3_name);
        modal.find('.modal-body #tree4_name').val(tree4_name);
        modal.find('.modal-body #phone').val(phone);

    })

</script>
<script>
    $('#modaldemo5').on('show.bs.modal', function(event) {
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
@endsection

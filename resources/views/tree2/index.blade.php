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
            <h4 class="content-title mb-0 my-auto"> أنشطة الحسابات </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المستوي الثاني</span>
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
                            msg: " تم إضافة الحساب بنجاح"
                            , type: "success"
                        })
                    }

                </script>
                @endif
                @if (session()->has('edit'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: " تم تحديث الحساب بنجاح"
                            , type: "success"
                        })
                    }

                </script>
                @endif
                @can('إضافة نشاط')
                <div class="d-flex">
                    <h5 class="content-title mb-0 my-auto"> إضاف حساب جديد :</h5>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="card-body">
                        <form action="{{route('tree2.store')}}" method="POST" class="form-horizontal form-label-left">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label> الحساب الرئيسي</label>
                                    <select required name="tree1_code" class="form-control">
                                        @foreach ($tree1s as $tree1)
                                        <option value="{{$tree1->tree1_code}}">{{$tree1->tree1_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </br>
                                <div class="col">
                                    <label for="inputName" class="control-label"> إسم الحساب</label>
                                    <input type="text" name="tree2_name" class="form-control" title="يرجي ادخال إسم الحساب" required>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary"> إضافة الحساب</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">متسلسل</th>
                                <th class="wd-5p border-bottom-0">كود الحساب </th>
                                <th class="wd-5p border-bottom-0">الحساب</th>
                                <th class="wd-5p border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($tree2s as $tree)

                            <tr>
                                <th scope="row">{{$id++}}</th>
                                <td>{{$tree->tree2_code}}</td>
                                <td>{{$tree->tree2_name}}</td>
                               

                                <td>
                                    @can('تعديل نشاط')
                                    <a class="modal-effect btn btn-outline-success btn-sm"
                                     data-effect="effect-super-scaled" data-toggle="modal" href="#modaldemo8"
                                      data-id="{{$tree->id}}" data-tree1_name="{{$tree->tree1->tree1_name}}" data-tree2_code="{{$tree->tree2_code}}" 
                                       data-tree2_name="{{$tree->tree2_name}}" title="تعديل">
                                       <i class="fa fa-edit">
                                        </i>&nbsp;&nbsp;تعديل </i></a>
                                        @endcan
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
    {{-- //edit model section   --}}
    <!-- Basic modal -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل إسم الحساب </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="tree2/update" method="post">
                    {{method_field('put')}}
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputName" class="control-label"> الحساب الرئيسي</label>
                            <input type="hidden" id="id" name="id" class="form-control">
                            <input   disabled class="form-control" name="tree1_name" id="tree1_name">
                        </div>
                        <div class="form-group">
                            <label>رقم الحساب</label>
                            <input  disabled name="tree2_code" id ="tree2_code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>اسم الحساب</label>
                            <input id="tree2_name" required type="text" name="tree2_name" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">تحديث البيانات </button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Basic modal -->
    <!-- row closed -->
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
        var tree1_name = button.data('tree1_name')
        var tree2_code = button.data('tree2_code')
        var tree2_name = button.data('tree2_name')

        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #tree1_name').val(tree1_name);
        modal.find('.modal-body #tree2_code').val(tree2_code);
            modal.find('.modal-body #tree2_name').val(tree2_name);

    })

</script>
@endsection

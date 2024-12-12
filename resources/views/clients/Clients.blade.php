@extends('layouts.master')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />

    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto"> الحجاج / المعتمرين</h5><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    قائمة الحجاج / المعتمرين</span>
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
                        <script>
                            window.onload = function() {
                                @foreach ($errors->all() as $error)
                                    notif({
                                        msg: "{{ $error }}",
                                        type: "error"
                                    });
                                @endforeach
                            }
                        </script>
                    @endif
                    @if (session()->has('success'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: " تم حفط البيانات بنجاح",
                                    type: "success"
                                })
                            }
                        </script>
                    @endif
                    @if (session()->has('file'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: " تم رفع الملف بنجاح  ",
                                    type: "success"
                                })
                            }
                        </script>
                    @endif

                    @if (session()->has('edit'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: " تم تحديث البيانات بنجاح",
                                    type: "success"
                                })
                            }
                        </script>
                    @endif
                    @if (session()->has('delete'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: " تم حذف البيانات بنجاح",
                                    type: "success"
                                })
                            }
                        </script>
                    @endif

                    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                        @can('إضافة حاج')
                            <a class="modal-effect btn btn-primary btn-block" data-effect="effect-super-scaled"
                                data-toggle="modal" href="#modaldemo8"><i class="fa fa-plus"> </i>&nbsp;&nbsp;إضافة حاج / معتمر
                                </i></a>
                        @endcan
                    </div>
                    {{-- <p class="tx-12 tx-gray-500 mb-2">Example of Valex Simple Table. <a href="">Learn more</a></p>  --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-1p border-bottom-0">م</th>
                                    <th class="wd-15p border-bottom-0"> الإسم </th>
                                    <th class="wd-10p border-bottom-0"> رقم الجواز </th>
                                    <th class="wd-10p border-bottom-0"> الجوال </th>
                                    <th class="wd-15p border-bottom-0"> البريد الالكتروني </th>
                                    {{-- <th class="wd-10p border-bottom-0"> العنوان </th> --}}
                                    <th class="wd-10p border-bottom-0"> الجنسية </th>
                                    <th class="wd-10p border-bottom-0"> الوكيل </th>
                                    <th class="wd-20p border-bottom-0">العمليات </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tree4s as $tree)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('file.show', $tree->id) }}">{{ $tree->tree4_name }}</a>
                                        </td>
                                        <td>{{ $tree->iden }}</td>
                                        <td>{{ $tree->phone }}</td>
                                        <td>{{ $tree->email }}</td>
                                        {{-- <td>{{ $tree->location }}</td> --}}
                                        <td>{{ $tree->nationalty }}</td>
                                        <td>
                                            @if ($tree->user->roles_name == 'agent')
                                                {{ $tree->user->name }}
                                            @else
                                                لا يوجد وكيل
                                            @endif
                                        </td>

                                        <td>
                                            @can('تعديل حاج')
                                                <a class="modal-effect btn btn-outline-success btn-sm"
                                                    data-effect="effect-super-scaled" data-toggle="modal" href="#modaldemo7"
                                                    data-id="{{ $tree->id }}" data-tree4_name="{{ $tree->tree4_name }}"
                                                    data-iden="{{ $tree->iden }}" data-phone="{{ $tree->phone }}"
                                                    data-tree3_name="{{ $tree->tree3->tree3_name }}"
                                                    data-email="{{ $tree->email }}" data-location="{{ $tree->location }}"
                                                    data-nationalty="{{ $tree->nationalty }}" data-type="{{ $tree->type }}"
                                                    title="تعديل">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('حذف حاج')
                                                <a class="modal-effect btn btn-outline-danger btn-sm" data-target="#modaldemo5"
                                                    data-toggle="modal" href="#modaldemo5" data-id="{{ $tree->id }}"
                                                    data-tree4_name="{{ $tree->tree4_name }}"
                                                    data-tree4_code="{{ $tree->tree4_code }}"
                                                    data-tree3_name="{{ $tree->tree3->tree3_name }}" title="حذف">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endcan
                                            {{-- @can('إضافة مرفقات') --}}
                                            <a class="modal-effect btn btn-outline-info btn-sm"
                                                data-target="#attachmentModal" data-toggle="modal" href="#attachmentModal"
                                                data-id="{{ $tree->id }}" title="إضافة مرفقات">
                                                <i class="fa fa-paperclip"></i>
                                            </a>
                                            {{-- @endcan --}}
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
        <!-- Basic modal -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog" role="document" style="max-width: 80%; /* يزيد عرض المودل */">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">إضافة بيانات </h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('Clients.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tree4_name">الإسم</label>
                                        <input type="text" name="tree4_name" id="tree4_name" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="type">النوع</label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="" disabled selected>اختر نوعاً</option>
                                            <option value="حاج">حاج</option>
                                            <option value="معتمر">معتمر</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phone">رقم الهوية</label>
                                        <input type="text" name="iden" id="iden" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vat_number">رقم الهاتف</label>
                                        <input type="number" name="phone" id="phone" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">البريد الإلكتروني</label>
                                        <input type="text" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="location">العنوان</label>
                                        <input type="text" name="location" id="location" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nationalty">الجنسية</label>
                                        <input type="text" name="nationalty" id="nationalty" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">إضافة</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->
        <div class="modal" id="modaldemo7">
            <div class="modal-dialog" role="document" style="max-width: 80%; /* يزيد عرض المودل */">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">تعديل البيانات</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="Clients/update" method="post">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input id="id" required type="hidden" name="id" class="form-control">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tree4_name">الإسم </label>
                                        <input id="tree4_name" required type="text" name="tree4_name"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="type">النوع</label>
                                        <select name="type" id="type" class="form-control nice-select  custom-select" required>
                                            <option value="" disabled selected>اختر نوعاً</option>
                                            <option value="حاج">حاج</option>
                                            <option value="معتمر">معتمر</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="iden">رقم الجواز</label>
                                        <input id="iden" required type="text" name="iden"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">رقم الهاتف</label>
                                        <input id="phone" type="text" name="phone" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">البريد الإلكتروني</label>
                                        <input id="email" type="email" name="email" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="location">العنوان</label>
                                        <input id="location" required type="text" name="location"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nationalty">الجنسية</label>
                                        <input id="nationalty" type="text" name="nationalty" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">تحديث البيانات</button>
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
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button> <i
                        class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <form action="Clients/destroy" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
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
    <div class="modal fade" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة مرفقات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="attachmentForm" action="{{ route('add_file') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="tree4_id" id="id">

                        {{-- file_name --}}
                        <div class="form-group">
                            <label for="attachments"> اسم المرفق</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="attachments">اختر المرفقات:</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div id="attachmentList"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    {{-- modals  --}}
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js') }}"></script>

    {{-- delete script  --}}
    <script>
        $('#modaldemo7').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var tree3_name = button.data('tree3_name')
            var tree4_name = button.data('tree4_name')
            var iden = button.data('iden')
            var phone = button.data('phone')
            var email = button.data('email')
            var location = button.data('location')
            var nationalty = button.data('nationalty')
            var file = button.data('file')
            var type = button.data('type');

            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #tree3_name').val(tree3_name);
            modal.find('.modal-body #tree4_name').val(tree4_name);
            modal.find('.modal-body #iden').val(iden);
            modal.find('.modal-body #phone').val(phone);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #location').val(location);
            modal.find('.modal-body #nationalty').val(nationalty);
            modal.find('.modal-body #file').val(file);
            modal.find('.modal-body #type').val(type);

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
    <script>
        $('#attachmentModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);

        })
    </script>
@endsection

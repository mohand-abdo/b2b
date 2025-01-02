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
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto"> قائمة المرفقات</h5>
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
                        <a class="modal-effect btn btn-primary btn-block" data-effect="effect-super-scaled"
                            data-toggle="modal" data-target="#attachmentModal" href="#attachmentModal"
                            title="إضافة مرفقات"><i class="fa fa-plus">
                            </i>&nbsp;&nbsp;إضافة مرفق
                            </i>
                        </a>
                    </div>
                    {{-- <p class="tx-12 tx-gray-500 mb-2">Example of Valex Simple Table. <a href="">Learn more</a></p>  --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-1p border-bottom-0" width="5%">م</th>
                                    @if (Auth::user()->roles_name == 'agent')
                                        <th class="wd-15p border-bottom-0" width="7%">الاسم</th>
                                    @endif
                                    <th class="wd-15p border-bottom-0" width="7%">الصورة</th>
                                    <th class="wd-10p border-bottom-0"> الإسم</th>
                                    <th class="wd-10p border-bottom-0"> التاريخ </th>
                                    <th class="wd-20p border-bottom-0">العمليات </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($files as $file)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @if (Auth::user()->roles_name == 'agent')
                                            <td>{{ $file->tree4->tree4_name }}</td>  
                                        @endif
                                        <td class="text-center">
                                            <a href="{{ asset('image/file/' . $file->file) }}"
                                                data-lightbox="{{ $file->name }}" data-title="{{ $file->name }}">
                                                <img src="{{ asset('image/file/' . $file->file) }}" alt="صورة مصغرة"
                                                    width="100">
                                            </a>
                                        </td>
                                        <td>{{ $file->name }}</td>
                                        <td>{{ $file->created_at }}</td>
                                        <td>

                                            <a class="modal-effect btn btn-outline-success btn-sm"
                                                data-effect="effect-super-scaled" data-toggle="modal"
                                                href="#updateattachmentModal" data-id="{{ $file->id }}"
                                                data-name="{{ $file->name }}" data-file="{{ $file->file }}"
                                                title="تعديل">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="modal-effect btn btn-outline-danger btn-sm" data-target="#modaldemo5"
                                                data-toggle="modal" href="#modaldemo5" data-id="{{ $file->id }}"
                                                title="حذف ">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            {{-- @can('إضافة مرفقات') --}}
                                            <a class=" btn btn-outline-info btn-sm"
                                                href="{{ asset('image/file/' . $file->file) }}" data-lightbox="example-set"
                                                data-title="{{ $file->name }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ asset('image/file/' . $file->file) }}"
                                                class=" btn btn-outline-primary btn-sm" title="تنزيل الصورة" download>
                                                <i class="fas fa-download"></i>
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
                    <form action="{{ route('file.destroy') }}" method="post">
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
    <div class="modal fade" id="attachmentModal">
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
                        @if (Auth::user()->roles_name == 'user')
                            <input type="hidden" name="tree4_id"  value="{{ $tree4Id }}">
                        @elseif (Auth::user()->roles_name == 'agent')
                            <div class="form-group">
                                <span class="tx-danger">*</span><label for="tree4_id">الحاج / المعتمر</label>
                                <select name="tree4_id" class="form-control select2" style="width: 100%" required></select> 
                            </div>
                        @endif

                        {{-- file_name --}}
                        <div class="form-group">
                            <span class="tx-danger">*</span><label for="attachments"> اسم المرفق</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <span class="tx-danger">*</span><label for="attachments">اختر المرفقات:</label>
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

    <div class="modal fade" id="updateattachmentModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل مرفقات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="attachmentForm" action="{{ route('file.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="tree4_id" value="{{ Auth::user()->roles_name == 'roles_name' ?  $tree4Id[0]->id : $tree4Id }}">
                        <input type="hidden" name="id" id="id">

                        {{-- file_name --}}
                        <div class="form-group">
                            <span class="tx-danger">*</span><label for="attachments"> اسم المرفق</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="attachments">اختر المرفقات:</label>
                            <input type="file" id="file" name="file" class="form-control">
                            <br />
                            <img src="#" id="imagePreview" alt="image" width="150" />
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

    {{-- delete script  --}}
    <script>
        $('#updateattachmentModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var file = button.data('file');

            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            var imageUrl = "{{ asset('image/file') }}/" + file;
            modal.find('.modal-body #imagePreview').attr('src', imageUrl); // تحديث مصدر الصورة

        });

        $('#modaldemo5').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')

            var modal = $(this)
            modal.find('.modal-body #id').val(id);

        });

        function select2list(selector, url, placeholder) {
            $(selector).select2({
                language: {
                    inputTooShort: function() {
                        return 'ادخل حرف واحد على الاقل';
                    }
                },
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page
                        };
                    },
                    processResults: function(data, params) {
                        console.log(data);
                        params.page = params.page || 1;
                        return {
                            results: data,
                            pagination: {
                                more: ((data.total_count) > (params.page * 20))
                            }
                        };
                    },
                    cache: true
                },
                placeholder: placeholder,
                minimumInputLength: 1,
            });

        };

        select2list(".select2", "{{ route('select2.getStatement') }}", "يرجى إدخال العميل");
    </script>
@endsection

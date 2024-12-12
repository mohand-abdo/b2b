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
                <h4 class="content-title mb-0 my-auto">إدارة الوكلاء</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    قائمة الوكلاء </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('delete'))
        <script>
            window.onload = function() {
                notif({
                    msg: " تم حذف الوكيل بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    {{-- alert change status  --}}
    @if (session()->has('edit'))
        <script>
            window.onload = function() {
                notif({
                    msg: " تم نحديث الوكيل بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            window.onload = function() {
                notif({
                    msg: " حفظ الوكيل بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    {{-- Uncomment to add a button for creating new contracts --}}
                    {{-- <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                        @can('إضافة عقد')
                            <a class="btn btn-primary btn-block" href="{{ route('Contract.create') }}">
                                <i class="fa fa-plus"></i>&nbsp;&nbsp;إضافة عقد جديد
                            </a>
                        @endcan
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">م</th>
                                    <th class="wd-10p border-bottom-0"> الاسم</th>
                                    <th class="wd-20p border-bottom-0"> رقم التلفون</th>
                                    <th class="wd-15p border-bottom-0"> البريد الالكتروني</th>
                                    <th class="wd-15p border-bottom-0"> التاريخ</th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $id = 0; ?>
                                @foreach ($agents as $agent)
                                    <?php $id++; ?>
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $agent->name }}</td>
                                        <td>{{ $agent->phone_number }}</td>
                                        <td>{{ $agent->email }}</td>
                                        <td>{{ $agent->created_at }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    العمليات <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @can('حذف عقد')
                                                        <a href="#" id="btnDelete" class="dropdown-item text-danger"
                                                            data-id="{{ $agent->id }}" data-toggle="modal"
                                                            data-target="#delete_invoice"
                                                            data-url="{{ route('agent.destroy', $agent->id) }}">
                                                            <i class="fas fa-trash-alt"></i>&nbsp;&nbsp;حذف الوكيل
                                                        </a>
                                                    @endcan
                                                    @can('تعديل عقد')
                                                        <a href="{{ route('agent.edit', $agent->id) }}"
                                                            class="dropdown-item text-warning">
                                                            <i class="fas fa-edit"></i>&nbsp;&nbsp;تعديل الوكيل
                                                        </a>
                                                    @endcan
                                                </div>
                                            </div>
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

    <!-- Modal for deleting contract -->
    <div class="modal" id="delete_invoice">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <form method="post">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" id="id" name="id" class="form-control">
                        <h4 class="tx-danger mg-b-20">هل تريد حذف هذا السجل بالفعل؟</h4>
                        <p class="mg-b-20 mg-x-20">في حالة الموافقة لا يمكنك التراجع عن هذا الإجراء!</p>
                        <button class="btn ripple btn-danger pd-x-25" type="submit">نعم, حذف السجل</button>
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
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // استهداف الزر الذي سيقوم بفتح المودال
            const deleteButton = document.getElementById('btnDelete');

            if (deleteButton) {
                deleteButton.addEventListener('click', function(event) {
                    // استهداف المودال
                    const modal = document.getElementById('delete_invoice');

                    if (modal) {
                        // الحصول على الزر الذي فتح المودال
                        const url = deleteButton.getAttribute('data-url'); // استخراج URL من الزر

                        const form = modal.querySelector('form');
                        if (form) {
                            form.setAttribute('action', url); // تحديث action الخاص بالنموذج
                        }

                        // فتح المودال يدوياً باستخدام Bootstrap 5 (إذا كنت تستخدمه)
                        const bootstrapModal = new bootstrap.Modal(modal);
                        bootstrapModal.show();
                    }
                });
            }
        });
    </script>
    {{-- <script>
        $('#exampleModel2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script> --}}
@endsection

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
                <h4 class="content-title mb-0 my-auto">إدارة العقود</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    قائمة عقودات الحجاج </span>
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
                    msg: " تم حذف البيانات بنجاح",
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
                    msg: " تم نحديث البيانات بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('Archive'))
        <script>
            window.onload = function() {
                notif({
                    msg: " تم أرشفة البيانات بنجاح",
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
                                    <th class="wd-10p border-bottom-0">رقم العقد</th>
                                    <th class="wd-20p border-bottom-0"> الحاج / المعتمر</th>
                                    <th class="wd-15p border-bottom-0"> الحملة</th>
                                    <th class="wd-15p border-bottom-0">المبلغ شامل الضريبة</th>
                                    <th class="wd-15p border-bottom-0">تاريخ العقد</th>
                                     <th class="wd-15p border-bottom-0"> المستخدم  </th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $id = 0; ?>
                                @foreach ($contracts as $contract)
                                    <?php $id++; ?>
                                    <tr>
                                        <td>{{ $id }}</td>
                                        <td>{{ $contract->id }}</td>
                                        <td>{{ $contract->tree4->tree4_name }}</td>
                                        <td>{{ $contract->Campaign->name }}</td>
                                        <td>{{ $contract->total_amount }}</td>
                                        <td>{{ $contract->contract_date }}</td>
                                        <td>{{ $contract->user->name }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    العمليات <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a href="{{route('Contract-print', $contract->id)}}" class="dropdown-item text-primary">
                                                        <i class="fas fa-print"></i>&nbsp;&nbsp;طباعة العقد
                                                    </a>
                                                    @can('حذف عقد')
                                                        <a href="#" class="dropdown-item text-danger"
                                                            data-id="{{ $contract->id }}" data-toggle="modal"
                                                            data-target="#delete_invoice">
                                                            <i class="fas fa-trash-alt"></i>&nbsp;&nbsp;حذف العقد
                                                        </a>
                                                    @endcan
                                                    @can('تعديل عقد')
                                                        <a href="{{ route('Contract.edit', $contract->id) }}"
                                                            class="dropdown-item text-warning">
                                                            <i class="fas fa-edit"></i>&nbsp;&nbsp;تعديل العقد
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
                    <form action="{{ route('Contract.destroy', 'test') }}" method="post">
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
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>
    <script>
        $('#exampleModel2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>
@endsection

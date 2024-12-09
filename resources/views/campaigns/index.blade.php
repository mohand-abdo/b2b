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
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto">حملات الحج والعمرة</h5><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الحملات</span>
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
                                    msg: " تم حفط البيانات بنجاح",
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
                        @can('إضافة حملة')
                            <a class="modal-effect btn btn-primary btn-block" data-effect="effect-super-scaled"
                                data-toggle="modal" href="#modaldemo8"><i class="fa fa-plus"> </i>&nbsp;&nbsp;إضافة حملة
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
                                    <th class="wd-5p border-bottom-0">متسلسل</th>
                                    <th class="wd-20p border-bottom-0">إسم الحملة </th>
                                    <th class="wd-15p border-bottom-0"> تاريخ الحملة </th>
                                    <th class="wd-20p border-bottom-0"> عدد الحجاج في الحملة </th>
                                    <th class="wd-10p">الحالة</th>
                                    <th class="wd-15p border-bottom-0"> تاريخ الإضافة </th>
                                    <th class="wd-15p border-bottom-0">العمليات </th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($campaigns as $key => $campaign)
                                    <tr data-id="{{ $campaign->id }}">
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $campaign->name }}</td>
                                        <td>{{ $campaign->date }}</td>
                                        <td>{{ \App\Models\Plus::where('campaign_id', $campaign->id)->count() }}</td>
                                        <!-- عرض عدد الحجاج في هذه الحملة -->
                                        <td>
                                            <button
                                                class="btn btn-sm btn-{{ $campaign->status ? 'success' : 'danger' }} toggle-status-btn"
                                                data-id="{{ $campaign->id }}">
                                                {{ $campaign->status ? 'نشط' : 'غير نشط' }}
                                            </button>
                                        </td>
                                        <td>{{ $campaign->created_at }}</td>
                                        <td>
                                            @can('تعديل حملة')
                                                <a class="modal-effect btn btn-outline-success btn-sm"
                                                    data-effect="effect-super-scaled" data-toggle="modal" href="#modaldemo7"
                                                    data-id="{{ $campaign->id }}" data-name="{{ $campaign->name }}"
                                                    data-date="{{ $campaign->date }}" title="تعديل">
                                                    <i class="fa fa-edit">
                                                    </i></i></a>
                                            @endcan
                                            @can('حذف حملة')
                                                <a class="modal-effect btn btn-outline-danger btn-sm" data-target="#modaldemo5"
                                                    data-toggle="modal" href="#modaldemo5" data-id="{{ $campaign->id }}"
                                                    data-name="{{ $campaign->name }}" data-date="{{ $campaign->date }}"
                                                    title="حذف">
                                                    <i class="fa fa-trash">
                                                    </i></i></a>
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

        <!-- Basic modal -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">إضافة حملة جديد </h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('campaigns.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">إسم الحملة </label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"> تاريخ الحملة </label>
                                <input type="date" name="date" id="phone" class="form-control" required>
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

        <div class="modal" id="modaldemo7">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">تعديل حملة </h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="campaigns/update" method="post">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label>اسم الحملة</label>
                                <input id="id" required type="hidden" name="id" class="form-control">
                                <input id="name" required type="text" name="name" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label> تاريخ الحملة</label>
                                <input id="date" required type="date" name="date" class="form-control"
                                    required>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-primary" type="submit">تحديث البيانات </button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal"
                                    type="button">إغلاق</button>
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
                    <form action="campaigns/destroy" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <input type="hidden" id="id" name="id" class="form-control">
                        <h4 class="tx-danger mg-b-20">هل تريد حذف هذا السجل بالفعل ؟</h4>
                        <input type="hidden" id="name" readonly name="name" class="form-control">
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
        $(document).ready(function() {
            // Handling data passing to edit and delete modals
            $('#modaldemo7').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');
                var date = button.data('date');
                var modal = $(this);

                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #date').val(date);
            });

            $('#modaldemo5').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                modal.find('.modal-body #id').val(id);
            });

            // Handling status toggle button click
            $('.toggle-status-btn').click(function() {
                var campaignId = $(this).data('id');
                var button = $(this);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('campaigns.toggleStatus', '') }}/' + campaignId,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        button.toggleClass('btn-success btn-danger');
                        button.text(response.status ? 'نشط' : 'غير نشط');
                        notif({
                            msg: 'تم تغيير حالة الحملة بنجاح',
                            type: 'success'
                        });
                    },
                    error: function() {
                        notif({
                            msg: 'حدث خطأ أثناء تغيير الحالة',
                            type: 'error'
                        });
                    }
                });
            });
        });
    </script>
@endsection

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
                <h5 class="content-title mb-0 my-auto"> مراحل الرحلة</h5><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    قائمة المراحل</span>
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
                    @if (session()->has('error'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: "المرحلة موجودة بالفعل لهذه الحملة.",
                                    type: "warning"
                                })
                            }
                        </script>
                    @endif

                    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                        @can('إضافة مرحلة')
                            <a class="modal-effect btn btn-primary btn-block" data-effect="effect-super-scaled"
                                data-toggle="modal" href="#modaldemo8"><i class="fa fa-plus"> </i>&nbsp;&nbsp;إضافة مرحلة
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
                                    <th class="wd-5p border-bottom-0">م</th>
                                    <th class="wd-20p border-bottom-0">إسم الحملة </th>
                                    <th class="wd-15p border-bottom-0"> اسم المرحلة </th>
                                    <th class="wd-10p border-bottom-0"> عدد الحجاج </th>
                                    <th class="wd-15p border-bottom-0"> تاريخ الإضافة </th>
                                    <th class="wd-25p border-bottom-0">العمليات </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stages as $key => $stage)
                                    <tr data-id="{{ $stage->id }}">
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $stage->campaign->name }}</td>
                                        <td>{{ $stage->stage }}</td>
                                        <td>{{ \App\Models\Plus::where('stage_id', $stage->id)->count() }}</td>
                                        <!-- عرض عدد الحجاج في هذه المرحلة -->
                                        <td>{{ $stage->created_at }}</td>
                                        <td>
                                            @can('إضافة حجاج للمرحلة')
                                                <a href="{{ route('Plus.index', ['id' => $stage->id, 'campaign' => $stage->campaign_id]) }}"
                                                    class="btn btn-outline-info btn-sm" title="عرض">
                                                    <i class="fa fa-plus"></i>&nbsp;&nbsp;إضافة حجاج للمرحلة
                                                </a>
                                            @endcan
                                            @can('تعديل مرحلة')
                                                <a class="modal-effect btn btn-outline-success btn-sm"
                                                    data-effect="effect-super-scaled" data-toggle="modal" href="#modaldemo7"
                                                    data-id="{{ $stage->id }}" data-campaign_id="{{ $stage->campaign_id }}"
                                                    data-stage="{{ $stage->stage }}" title="تعديل">
                                                    <i class="fa fa-edit">
                                                    </i></i></a>
                                            @endcan
                                            @can('حذف مرحلة')
                                                <a class="modal-effect btn btn-outline-danger btn-sm" data-target="#modaldemo5"
                                                    data-toggle="modal" href="#modaldemo5" data-id="{{ $stage->id }}"
                                                    data-campaign_id="{{ $stage->campaign_id }}"
                                                    data-stage="{{ $stage->stage }}" title="حذف">
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
                        <h6 class="modal-title">إضافة مرحلة جديدة</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('Stages.store') }}" method="post" onsubmit="disableSubmitButton(this)">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="campaign_id">إسم الحملة</label>
                                <select name="campaign_id" id="campaign_id" class="form-control" required>
                                    <option value="">اختر الحملة</option>
                                    @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="stage">اسم المرحلة</label>
                                <input type="text" name="stage" id="stage" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit" id="submitBtn">إضافة</button>
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
                        <h6 class="modal-title">تعديل مرحلة</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="Stages/update" method="post">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="campaign_id">اسم الحملة</label>
                                <input id="id" required type="hidden" name="id" class="form-control">
                                <select id="campaign_id" name="campaign_id" class="form-control" required>
                                    <option value="">اختر الحملة</option>
                                    @php
                                        $campaigns = \App\Models\Campaigns::where('status', 1)->get();
                                    @endphp
                                    @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="stage">اسم المرحلة</label>
                                <input id="stage" required type="text" name="stage" class="form-control"
                                    required>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-primary" type="submit">تحديث البيانات</button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal"
                                    type="button">إغلاق</button>
                            </div>
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
                    <form action="Stages/destroy" method="post">
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
                var campaign_id = button.data('campaign_id');
                var stage = button.data('stage');
                var modal = $(this);

                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #campaign_id').val(campaign_id);
                modal.find('.modal-body #stage').val(stage);
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
    <script>
        function disableSubmitButton(form) {
            form.querySelector('#submitBtn').disabled = true;
        }
    </script>
@endsection
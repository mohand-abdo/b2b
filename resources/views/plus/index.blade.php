@extends('layouts.master')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet"> --}}
    <!-- Internal Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <!-- Print styles -->
    <style>
        @media print {
            .no-print {
                display: none;
            }

            .printable {
                direction: rtl;
                text-align: right;
            }
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto">إدارة الحجاج / المعتمرين </h5><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    إضافة حجاج / معتمرين للمرحلة </span>
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
                                    msg: "تم حفظ البيانات بنجاح",
                                    type: "success"
                                });
                            }
                        </script>
                    @endif

                    @if (session()->has('delete'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: "تم حذف البيانات بنجاح",
                                    type: "success"
                                });
                            }
                        </script>
                    @endif
                    @if (session()->has('error'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: "الحاج موجود بالفعل لهذه المرحلة.",
                                    type: "warning"
                                });
                            }
                        </script>
                    @endif

                    <div class="button-group no-print">
                        <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                            <button class="btn btn-secondary btn-block" onclick="printTable()"><i class="fa fa-print">
                                </i>&nbsp;&nbsp;طباعة</button>
                        </div>
                        <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                            <a class="modal-effect btn btn-primary btn-block" data-effect="effect-super-scaled"
                                data-toggle="modal" href="#modaldemo8"><i class="fa fa-plus"> </i>&nbsp;&nbsp;إضافة حاج / معتمر 
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th class="wd-5p border-bottom-0">م</th>
                                    <th class="wd-15p border-bottom-0">اسم الحملة</th>
                                    <th class="wd-15p border-bottom-0">اسم المرحلة</th>
                                    <th class="wd-20p border-bottom-0">اسم الحاج / المعتمر</th>
                                    <th class="wd-15p border-bottom-0">تاريخ الإضافة</th>
                                    <th class="wd-10p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pluses as $key => $plus)
                                    <tr data-id="{{ $plus->id }}">
                                        <td><input type="checkbox" class="row-checkbox"></td>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $plus->Campaign->name }}</td>
                                        <td>{{ $plus->stage->stage }}</td>
                                        <td>{{ $plus->tree4->tree4_name }}</td>
                                        <td>{{ $plus->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a class="modal-effect btn btn-outline-danger btn-sm" data-target="#modaldemo5"
                                                data-toggle="modal" href="#modaldemo5" data-id="{{ $plus->id }}"
                                                title="حذف">
                                                <i class="fa fa-trash"></i>&nbsp;&nbsp;حذف
                                            </a>
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

        <!-- Add New Haj Modal -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">إضافة حاج جديد</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('Plus.store') }}" method="post" onsubmit="disableSubmitButton(this)">
                        {{ csrf_field() }}
                        <input type="hidden" name="stage_id" value="{{ request('id') }}">
                        <input type="hidden" name="campaign_id" value="{{ request('campaign') }}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tree4_id">الحاج / المعتمر</label>
                                <select name="tree4_id" class="form-control" required>
                                    <option value="">-- اختر الحاج / المعتمر --</option>
                                    @foreach ($tree4 as $x)
                                        <option value="{{ $x->id }}">{{ $x->tree4_name }}</option>
                                    @endforeach
                                </select>
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
        <!-- End Add New Haj Modal -->

        <!-- Delete Confirmation Modal -->
        <div class="modal" id="modaldemo5">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-body tx-center pd-y-20 pd-x-20">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                        <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                        <form action="{{ route('Plus.destroy', 'id') }}" method="post">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <input type="hidden" id="id" name="id" class="form-control">
                            <h4 class="tx-danger mg-b-20">هل تريد حذف هذا السجل بالفعل ؟</h4>
                            <p class="mg-b-20 mg-x-20">في حالة الموافقة لا يمكنك التراجع عن هذا الإجراء!</p>
                            <button class="btn ripple btn-danger pd-x-25" type="submit">نعم, حذف السجل</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إلغاء</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Delete Confirmation Modal -->
    </div>
    </div>
    </div>
    <!-- row closed -->
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
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable();

            $('#tree4_id').select2();

            $('#modaldemo5').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                modal.find('.modal-body #id').val(id);
            });

            // Display success, error, and delete messages
            @if (session()->has('success'))
                notif({
                    msg: "{{ session('success') }}",
                    type: "success"
                });
            @endif

            @if (session()->has('error'))
                notif({
                    msg: "{{ session('error') }}",
                    type: "warning"
                });
            @endif

            @if (session()->has('delete'))
                notif({
                    msg: "{{ session('delete') }}",
                    type: "success"
                });
            @endif

            $('#select-all').on('click', function() {
                var checked = this.checked;
                $('.row-checkbox').each(function() {
                    this.checked = checked;
                });
            });
        });

        function disableSubmitButton(form) {
            var submitBtn = form.querySelector('#submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'جاري الإضافة...';
        }

        function printTable() {
            var printWindow = window.open('', '', 'height=600,width=800');
            var html = `
                <html>
                <head>
                    <title>Print View</title>
                    <style>
                        body { direction: rtl; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 8px; }
                        th { background-color: #f2f2f2; }
                    </style>
                </head>
                <body>
                    <h1>عرض للطباعة</h1>
                    <table>
                        <thead>
                            <tr>
                              <th>الحملة </th>
                                <th>اسم المرحلة</th>
                                <th>اسم الحاج / المعتمر</th>
                                <th>تاريخ الإضافة</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            $('#example1 tbody tr').each(function() {
                var Campaign = $(this).find('td').eq(2).text();
                var stage = $(this).find('td').eq(3).text();
                var name = $(this).find('td').eq(4).text();
                var date = $(this).find('td').eq(5).text();
                html += `
                    <tr>
                     <td>${Campaign}</td>
                        <td>${stage}</td>
                        <td>${name}</td>
                        <td>${date}</td>
                    </tr>
                `;
            });

            html += `
                        </tbody>
                    </table>
                </body>
                </html>
            `;

            printWindow.document.write(html);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }
    </script>
@endsection

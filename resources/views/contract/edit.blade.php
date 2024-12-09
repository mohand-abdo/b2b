@extends('layouts.master')

@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!-- Internal Fileupload css -->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!-- Internal Fancy uploader css -->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!-- Internal Sumoselect css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!-- Internal TelephoneInput css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <!-- Internal Notify css -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">إدارة العقودات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل عقد</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    @if (session()->has('success'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تحديث البيانات بنجاح",
                    type: "success"
                });
            }
        </script>
    @endif

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('Contract.update', $contract->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <!-- Row 1 -->
                        <div class="row">
                            <div class="col-md-4">
                                <label>الحاج</label>
                                <select id="tree4_id" name="tree4_id" class="form-control" required>
                                    <option value="">--  اختر الحاج / المعتمر--</option>
                                    @foreach ($tree4 as $x)
                                        <option value="{{ $x->id }}" {{ $x->id == $contract->tree4_id ? 'selected' : '' }}>
                                            {{ $x->tree4_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>حملات الحج والعمرة</label>
                                <select id="campaign_id" name="campaign_id" class="form-control" required>
                                    <option value="">-- اختر الحملة --</option>
                                    @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}" {{ $campaign->id == $contract->campaign_id ? 'selected' : '' }}>
                                            {{ $campaign->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>الحساب</label>
                                <select id="live_bank_and_safe" required name="bank_and_safe" class="form-control">
                                    <option value="">-- اختر الحساب --</option>
                                    @foreach ($tree4s as $tree)
                                        <option value="{{ $tree->tree4_code }}" {{ $tree->tree4_code == $contract->bank_and_safe ? 'selected' : '' }}>
                                            {{ $tree->tree4_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br>

                        <!-- Row 2 -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>رقم الحاج / المعتمر </label>
                                <input type="text" name="hajj_number" class="form-control" value="{{ $contract->hajj_number }}" required>
                            </div>

                            <div class="col-md-2">
                                <label>رقم الغرفة</label>
                                <input type="text" name="room_number" class="form-control" value="{{ $contract->room_number }}" required>
                            </div>

                            <div class="col-md-2">
                                <label>رقم الحافلة</label>
                                <input type="text" name="bus_number" class="form-control" value="{{ $contract->bus_number }}" required>
                            </div>

                            <div class="col-md-6">
                                <label>مرفق</label>
                                <input type="file" name="attachment" class="form-control">
                                @if ($contract->attachment)
                                    <a href="{{ asset('image/contract/' . $contract->attachment) }}" target="_blank">عرض المرفق الحالي</a>
                                @endif
                            </div>
                        </div>

                        <br>

                        <!-- Row 3 -->
                        <div class="row">
                            <div class="col-md-3">
                                <label>المبلغ</label>
                                <input type="text" id="amount" name="amount" class="form-control" value="{{ $contract->amount }}" required>
                            </div>

                            <div class="col-md-3">
                                <label>الضريبة (%)</label>
                                <input type="text" id="tax" name="tax" class="form-control" value="{{ $contract->tax }}" required>
                            </div>

                            <div class="col-md-3">
                                <label>المبلغ شامل الضريبة</label>
                                <input type="text" id="total_amount" name="total_amount" class="form-control" value="{{ $contract->total_amount }}" readonly required>
                            </div>

                            <div class="col-md-3">
                                <label>تاريخ العقد</label>
                                <input type="date" name="contract_date" class="form-control datepicker" value="{{ $contract->contract_date }}" required>
                            </div>
                        </div>

                        <br>

                        <!-- Row 4 -->
                        <div class="row">
                            <div class="col-md-12">
                                <label>شروط العقد</label>
                                <textarea name="contract_terms" class="form-control" id="ckeditor" rows="3">{{ $contract->contract_terms }}</textarea>
                            </div>
                        </div>

                        <br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">تحديث البيانات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Internal Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Fileuploads js -->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!-- Internal Fancy uploader js -->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!-- Internal Form-elements js -->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!-- Internal TelephoneInput js -->
    <script src="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js') }}"></script>
    <!-- Internal notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <!-- Internal CKEditor js -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        // Initialize CKEditor
        CKEDITOR.replace('ckeditor');

        // Calculate total amount including tax
        document.getElementById('amount').addEventListener('input', calculateTotal);
        document.getElementById('tax').addEventListener('input', calculateTotal);

        function calculateTotal() {
            var amount = parseFloat(document.getElementById('amount').value) || 0;
            var tax = parseFloat(document.getElementById('tax').value) || 0;
            var totalAmount = amount + (amount * tax / 100);
            document.getElementById('total_amount').value = totalAmount.toFixed(2);
        }
    </script>
@endsection

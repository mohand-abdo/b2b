@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <style>
    .cke_warning,
    .cke_warning_box,
    .cke_warning_text {
        display: none !important;
    }
</style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto">إعدادت النظام</h5><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الإعداد العامة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('Add'))
        <script>
            window.onload = function() {
                notif({
                    msg: " تم تحديث الإعدادت بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    <!-- row -->
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action=" {{ route('settings_update') }}" method="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        {{-- 1 --}}

                        <div class="row">
                            {{--  <input type="hidden" class="form-control" value="{{$setting->id }}" id="inputName" name="id" title="يرجي ادخال إسم الـمؤسسة" required>  --}}
                            <div class="col">
                                <label for="inputName" class="control-label"> إسم الشركة </label>
                                <input type="text" class="form-control" value="{{ $setting->name }}" id="inputName"
                                    name="name" title="يرجي ادخال إسم الـمؤسسة" required>
                            </div>

                            {{-- <div class="col">
                            <label>رقم السجل التجاري  </label>
                            <input class="form-control " name="section" type="text" value="{{$setting->section}}" required title="يرجي ادخال السجل التجاري">
                        </div> --}}

                            <div class="col">
                                <label> العنوان</label>
                                <input class="form-control" name="location" value="{{ $setting->location }}"
                                    title="يرجي ادخال العنوان " type="text" required>
                            </div>

                        </div>
                        </br>
                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label"> هاتف </label>
                                <input type="text" class="form-control" id="inputName" name="phone"
                                    value="{{ $setting->phone }}" title="يرجي ادخال رقم الهاتف" required>
                            </div>

                            <div class="col">
                                <label> البريد الإلكتروني</label>
                                <input class="form-control " name="email" value="{{ $setting->email }}" type="text"
                                    value="" required title="يرجي ادخال الإيميل ">
                            </div>


                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <img style="width: 180px; height: 180px; object-fit: cover;"
                                    src="{{ asset('image/logo/' . $setting->logo) }}" alt="لا يوجد شعار حاليا"
                                    srcset="">
                            </div>
                        </div>

                        </br>
                        <div class="row">
                            <div class="col">
                                <label> شروط العقد</label>
                                <textarea class="form-control" id="conditions" name="conditions" required>{{ $setting->conditions }}</textarea>
                            </div>
                              <script>
                                        CKEDITOR.replace('conditions');
                                    </script>
                        </div>

                        {{-- show logo  --}}
                        {{-- 4 --}}
                        <br>
                        <p class="text-danger">* صيغة الشعـار &nbsp; jpeg ,.jpg , png </p>
                        <h5 class="card-title">الشعـار</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="logo" class="dropify"
                                accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="70" />
                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">تحديث البيانات</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <!-- CKEditor script -->
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
   <script>
        // العثور على جميع الحقول النصية التي تستخدم CKEditor وتطبيق التعطيل عليها
        document.querySelectorAll('textarea').forEach(function(textarea) {
            CKEDITOR.replace(textarea.id);
        });

        // تعطيل التحذيرات لجميع المحررات
        CKEDITOR.on('instanceReady', function(evt) {
            var editor = evt.editor;
            editor.on('notificationShow', function(e) {
                if (e.data.message.indexOf('The license key is missing or invalid') !== -1 || e.data.message
                    .indexOf('This CKEditor version is not secure') !== -1) {
                    e.cancel();
                }
            });
        });
    </script>
@endsection

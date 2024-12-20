@extends('layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                    مستخدم</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>خطا</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}">رجوع</a>
                        </div>
                    </div><br>

                    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id]]) !!}
                    <div class="">

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>اسم الوكيل: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control" data-parsley-class-handler="#lnWrapper"
                                    name="name" required="" type="text" value="{{ old('name', $user->name) }}">
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                                <label>البريد الالكتروني: <span class="tx-danger">*</span></label>
                                <input class="form-control" data-parsley-class-handler="#lnWrapper" name="email"
                                    type="email" value="{{ old('email', $user->email) }}">
                            </div>
                        </div>

                    </div>

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                            <label>كلمة المرور: <span class="tx-danger">*</span></label>
                            <input class="form-control" data-parsley-class-handler="#lnWrapper" name="password"
                                type="password">
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                            <label> تاكيد كلمة المرور: <span class="tx-danger">*</span></label>
                            <input class="form-control" data-parsley-class-handler="#lnWrapper" name="confirm-password"
                                type="password">
                        </div>
                    </div>
                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                            <label> رقم التلفون: <span class="tx-danger">*</span></label>
                            <input class="form-control" data-parsley-class-handler="#lnWrapper" name="phone_number"
                                required="" type="number" value="{{ old('phone_number', $user->phone_number) }}">
                        </div>
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                            <label>حالة المستخدم</label>
                            <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                                <option value="مفعل" {{ old('Status', $user->Status) == 'مفعل' ? 'selected' : '' }}>مفعل
                                </option>
                                <option value="غير مفعل"
                                    {{ old('Status', $user->Status) == 'غير مفعل' ? 'selected' : '' }}>غير مفعل</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                            <div class="form-group">
                                <strong>نوع المستخدم</strong>
                                {!! Form::select('roles', $roles, old('roles', $userRole), ['class' => 'form-control nice-select']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="mg-t-30">
                        <button class="btn btn-main-primary pd-x-20" type="submit">تحديث</button>
                    </div>
                    {!! Form::close() !!}
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
    <!-- Internal Nice-select js-->
    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js') }}"></script>

    <!--Internal  Parsley.min js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
@endsection

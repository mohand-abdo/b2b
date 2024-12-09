@extends('layouts.master')

@section('css')
    <style>
        @media print {
            #print_Button {
                display: none !important;
            }
        }
        .download-btn {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            margin-left: 10px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #007bff;
            border-radius: 4px;
        }
        .download-btn:hover {
            background-color: #007bff;
            color: white;
        }
        .download-btn i {
            margin-right: 5px;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">تفاصيل الحاج</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ عرض تفاصيل</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class="card card-invoice">
                <div class="card-body">
                    <h4 class="invoice-title">تفاصيل الحاج</h4>
                    <br>
                    <p><strong>الإسم:</strong> {{ $tree->tree4_name }}</p>
                    <p><strong>رقم الجواز:</strong> {{ $tree->iden }}</p>
                    <p><strong>الجوال:</strong> {{ $tree->phone }}</p>
                    <p><strong>البريد الإلكتروني:</strong> {{ $tree->email }}</p>
                    <p><strong>العنوان:</strong> {{ $tree->location }}</p>
                    <p><strong>الجنسية:</strong> {{ $tree->nationalty }}</p>
                    <p><strong>الوكيل:</strong> {{ $tree->user ? $tree->user->name : 'لا يوجد وكيل' }}</p>

                    <h4>المرفقات:</h4>
                    @if ($files->isNotEmpty())
                        <ul>
                            @foreach ($files as $file)
                                <li>
                                    <a href="{{ asset('image/file/' . $file->file) }}" target="_blank">
                                        {{ $file->name }}
                                    </a>
                                    <a href="{{ asset('image/file/' . $file->file) }}" class="download-btn" download>
                                        <i class="fas fa-download"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>لا توجد مرفقات لهذا الحاج.</p>
                    @endif

                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
@endsection

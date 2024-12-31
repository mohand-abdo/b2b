<!-- main-sidebar -->

<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ url('/' . ($page = 'home')) }}"><img
                src="{{ asset('image/logo/' . Helper::GeneralSiteSettings('logo')) }}" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="{{ url('/' . ($page = 'home')) }}"><img
                src="{{ URL::asset('assets/img/brand/logo-white.png') }}" class="main-logo dark-theme"
                alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . ($page = 'home')) }}"><img
                src="{{ URL::asset('assets/img/brand/favicon.png') }}" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . ($page = 'home')) }}"><img
                src="{{ URL::asset('assets/img/brand/favicon-white.png') }}" class="logo-icon dark-theme"
                alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    <img alt="user-img" class="avatar avatar-xl brround"
                        src="{{ asset('image/logo/' . Helper::GeneralSiteSettings('logo')) }}"><span
                        class="avatar-status profile-status bg-green"></span>
                </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0">{{ Auth::user()->name }}</h4>
                    <span class="mb-0 text-muted">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>
        <ul class="side-menu">
            <li class="side-item side-item-category">برنامج إداراة شركات الحج والعمرة</li>
            {{-- @if (!auth()->user() || auth()->user()->roles_name != ['agent'])
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/' . ($page = 'home')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                        </svg><span class="side-menu__label">الرئيسية</span>
                    </a>
                </li>
            @endif --}}
            @can('حملات الحج والعمرة')
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/' . ($page = 'home')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                        </svg><span class="side-menu__label">الرئيسية</span>
                    </a>
                </li>
            @endcan
            @can('حملات الحج والعمرة')
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/' . ($page = 'campaigns')) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <!-- الكعبة -->
                            <path d="M2 6h20v12H2V6z" fill="#000" />
                            <path d="M2 6h20v2H2V6zM2 18h20v-2H2v2z" fill="#fff" />
                            <path d="M4 8h16v4H4V8z" fill="#fff" />
                            <path d="M4 12h16v2H4v-2z" fill="#000" />
                            <path d="M4 14h16v2H4v-2z" fill="#fff" />
                            <path d="M4 16h16v2H4v-2z" fill="#000" />
                            <path d="M6 6h12v2H6V6zM6 18h12v2H6v-2z" fill="#fff" />
                        </svg>
                        <span class="side-menu__label">حملات الحج والعمرة</span>
                    </a>
                </li>
            @endcan
            @can('الحجاج')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5s-3 1.34-3 3 1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg><span class="side-menu__label"> الحجاج / المعتمرين</span><i class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('قائمة الحجاج')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Clients')) }}">قائمة الحجاج / المعتمرين </a></li>
                        @endcan
                        @can('قائمة الحجاج غير المفعلين')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Clients_inactive')) }}">قائمة الحجاج / المعتمرين غير المفعلين </a></li>
                        @endcan
                        @can('دفعيات الحجاج')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'ClientPay')) }}">الدفعيات   </a></li>
                        @endcan
                        @can('كشف حساب حاج')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'client_statement')) }}">كشف حساب  </a>
                            </li>

                            <li><a class="slide-item" href="{{ url('/' . ($page = 'campaign_statement')) }}">كشف حساب بواسطة الحملات  </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('العقود')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 5h15v3H5zm12 5h3v9h-3zm-7 0h5v9h-5zm-5 0h3v9H5z" opacity=".3" />
                            <path
                                d="M20 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h15c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM8 19H5v-9h3v9zm7 0h-5v-9h5v9zm5 0h-3v-9h3v9zm0-11H5V5h15v3z" />
                        </svg><span class="side-menu__label"> العقود</span><i class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('قائمة العقود')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Contract')) }}">قائمة العقود </a>
                            </li>
                        @endcan
                        @can('إضافة عقد جديد')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Add_Contract')) }}">إضافة عقد جديد</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('مراحل الرحلة')
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/' . ($page = 'Stages')) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                                fill="none" />
                            <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                        <span class="side-menu__label"> مراحل الرحلة </span>
                    </a>
                </li>
            @endcan
            @can('إدارة الحسابات')
                <li class="side-item side-item-category" style="font-weight: bold;"> الإدارة العامة للنظام </li>
            @endcan
            @can('إدارة الحسابات')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M15 11V4H4v8.17l.59-.58.58-.59H6z" opacity=".3" />
                            <path
                                d="M21 6h-2v9H6v2c0 .55.45 1 1 1h11l4 4V7c0-.55-.45-1-1-1zm-5 7c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1H3c-.55 0-1 .45-1 1v14l4-4h10zM4.59 11.59l-.59.58V4h11v7H5.17l-.58.59z" />
                        </svg><span class="side-menu__label">إدارة الحسابات</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('القيود اليومية')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Operation')) }}">قيود اليومية</a></li>
                        @endcan
                        @can('القيود المركبة')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Vehicle')) }}">القيود المركبة </a></li>
                        @endcan
                        @can('إدارة قيود اليومية')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Alldaily')) }}"> إدارة قيود اليومية </a>
                            </li>
                        @endcan
                        @can('الارصدة الافتتاحية')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Balance')) }}">إضافة رصيد إفتتاحي </a>
                            </li>
                        @endcan
                        @can('إدارة الأرصدة الأفتتاحية')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Allbalance')) }}"> إدارة الأرصدة
                                    الأفتتاحية
                                </a></li>
                        @endcan
                        {{--  <li><a class="slide-item" href="{{ url('/' . $page='Restrictions') }}"> القيود العامة </a></li>  --}}
                    </ul>
                </li>
            @endcan
            @can('التقارير المحاسبية')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M4 12c0 4.08 3.06 7.44 7 7.93V4.07C7.05 4.56 4 7.92 4 12z" opacity=".3" />
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93s3.05-7.44 7-7.93v15.86zm2-15.86c1.03.13 2 .45 2.87.93H13v-.93zM13 7h5.24c.25.31.48.65.68 1H13V7zm0 3h6.74c.08.33.15.66.19 1H13v-1zm0 9.93V19h2.87c-.87.48-1.84.8-2.87.93zM18.24 17H13v-1h5.92c-.2.35-.43.69-.68 1zm1.5-3H13v-1h6.93c-.04.34-.11.67-.19 1z" />
                        </svg><span class="side-menu__label">التقارير المحاسبية</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('تقرير كشف حسابات')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'statement')) }}"> تقرير كشف حسابات </a>
                            </li>
                        @endcan
                        @can('دفتر اليومية')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Journal')) }}"> دفتر اليومية </a></li>
                        @endcan
                        @can('تقرير قيد يومية')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'DailyReport')) }}"> تقرير قيد يومية </a>
                            </li>
                        @endcan
                        @can('الدفاتر المحاسبية')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Books')) }}"> الدفاتر المحاسبية </a></li>
                        @endcan
                        {{--  <li><a class="slide-item" href="{{ url('/' . $page='Operation') }}">الارصدة الافتتاحية </a></li>   --}}
                    </ul>
                </li>
            @endcan

            @can('الأنشطة المحــاسبية')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                        </svg><span class="side-menu__label">الأنشطة المحــاسبية</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('المستوي الاول')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'tree1')) }}">المستوى الاول </a></li>
                        @endcan
                        @can('المستوي الثاني')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'tree2')) }}">المستوى الثاني </a></li>
                        @endcan
                        @can('المستوي الثالث')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'tree3')) }}">المستوى الثالث </a></li>
                        @endcan
                        @can('المستوي الرابع')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'tree4')) }}">المستوى الرابع </a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('المستخدمين والصلاحيات')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M15 11V4H4v8.17l.59-.58.58-.59H6z" opacity=".3" />
                            <path
                                d="M21 6h-2v9H6v2c0 .55.45 1 1 1h11l4 4V7c0-.55-.45-1-1-1zm-5 7c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1H3c-.55 0-1 .45-1 1v14l4-4h10zM4.59 11.59l-.59.58V4h11v7H5.17l-.58.59z" />
                        </svg><span class="side-menu__label">المستخدمين والصلاحيات</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('قائمة المستخدمين')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'users')) }}">قائمة المستخدمين</a></li>
                        @endcan
                        @can('صلاحيات المستخدمين')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'roles')) }}">صلاحيات المستخدمين </a></li>
                        @endcan
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'trashed_users')) }}"> المستخدمين المؤرشفين </a></li>

                        @can('ادارة الوكلاء')
                            <li><a class="slide-item" href="{{ route('agent.index') }}">قائمة الوكلاء</a></li>
                        @endcan
                        @can('اضافة وكيل')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'agent/create')) }}">اضافة وكيل </a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('إعدادات النظام')
                <li class="side-item side-item-category">الإعدادات</li>
            @endcan
            @can('إعدادات النظام')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 5h15v3H5zm12 5h3v9h-3zm-7 0h5v9h-5zm-5 0h3v9H5z" opacity=".3" />
                            <path
                                d="M20 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h15c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM8 19H5v-9h3v9zm7 0h-5v-9h5v9zm5 0h-3v-9h3v9zm0-11H5V5h15v3z" />
                        </svg><span class="side-menu__label"> إعدادات النظام </span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('الإعدادات العامة')
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'Setting')) }}">الإعدادات العامة </a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('اضافة حاج ل بياناته')
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/' . ($page = 'Clients/create')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5s-3 1.34-3 3 1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg><span class="side-menu__label">اضافة البيانات</span>
                    </a>
                </li>
            @endcan
            @can('اضافة مرفق')
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/' . ($page = 'Clients_pic')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 5h15v3H5zm12 5h3v9h-3zm-7 0h5v9h-5zm-5 0h3v9H5z" opacity=".3" />
                            <path
                                d="M20 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h15c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM8 19H5v-9h3v9zm7 0h-5v-9h5v9zm5 0h-3v-9h3v9zm0-11H5V5h15v3z" />
                        </svg><span class="side-menu__label"> المرفقات</span>
                    </a>
                </li>
            @endcan
            @can('كشف حساب عميل')
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/' . ($page = 'client_myStatement')) }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M15 11V4H4v8.17l.59-.58.58-.59H6z" opacity=".3" />
                            <path
                                d="M21 6h-2v9H6v2c0 .55.45 1 1 1h11l4 4V7c0-.55-.45-1-1-1zm-5 7c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1H3c-.55 0-1 .45-1 1v14l4-4h10zM4.59 11.59l-.59.58V4h11v7H5.17l-.58.59z" />
                        </svg><span class="side-menu__label">كشف حساب</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</aside>
<!-- main-sidebar -->

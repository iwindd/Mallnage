<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@if (auth()->user() == null || (auth()->user() !== null && auth()->user()->isAdmin != 0))
    @php
        $__isAdmin = true;
    @endphp
@else
    @php
        $__isAdmin = false;
    @endphp
@endif

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cooperative') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('css/font.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
    
    <!-- Script -->

    <script src="{{ asset('js/fontawesome.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}" ></script>
    <script>
        const ___month     = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
        const ___monthMini = [ "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
        const ___day       = ["วันอาทิตย์","วันจันทร์","วันอังคาร","วันพุธ","วันพฤหัส","วันศุกร์","วันเสาร์"];
        const ___dayMini   = ["ศ.", "ส.", "อา.", "จ.","อ.", "พ.", "พฤ."];
    </script>


    @if ($__isAdmin == false)
    <style>
        .nav-link{
            color: black !important;
        }

        .nav-link.active{
            color:#22b8f0 !important;
        }

        /* #22b8f0 */
    </style>
    @endif
</head>

<body>
    <div id="app">
        @if ($__isAdmin)
            <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        @else
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        @endif
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                   {{--  {{ config('app.name', 'Laravel') }} --}}
                    @if ($__isAdmin)
                        Mallnage
                    @else
                        {{empty(session('cooperative:title')) ? 'Cooperative':session('cooperative:title')}}
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">เข้าสู่ระบบ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('signup') }}">ลงทะเบียน</a>
                                </li>
                            @endif
                        @else
                            @if (auth()->user() !== null && auth()->user()->isAdmin == 0) 
                                @include('layouts.template.user')
                            @else
                                @include('layouts.template.admin')
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>



    </div>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>


    <script>
        const back = () => {
            location.href = document.referrer;
            return false;
        }

        const setcookie = (cname, cvalue, exdays) => {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }


        const getCookie = (cname) => {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }


        $(document).ready(function() {
            $('[data-apply-form]').on('click', function() {
                const formId = $(this).data('apply-form');
                const form = $(`#${formId}`);

                form.submit();
            })
        })
    </script>

    @yield('footer')
</body>

</html>

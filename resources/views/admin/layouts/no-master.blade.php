<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Xuất form khảo sát')</title>

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/logo_vnua.png') }}" type="image/x-icon">

    <!-- Fonts & Icons -->
    <link href="{{ asset('assets/admin/fonts/inter/inter.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/icons/phosphor/styles.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/icons/fontawesome/styles.min.css') }}" rel="stylesheet">

    <!-- Theme & Custom CSS -->
    <link href="{{ asset('assets/admin/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/on-off light.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/department.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/noty/noty.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/hicolor.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/login-admin.css') }}" rel="stylesheet">

    <!-- NProgress -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" rel="stylesheet" />

    <!-- Custom Style -->
    <style>
        html, body {
            height: auto;
            overflow-y: auto;
            background-color: #f1f3f4;
            font-family: 'Inter', sans-serif;
        }

        /* .google-form-style {
            max-width: 850px;
            margin: auto;
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .google-form-style .form-section {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .google-form-style h5,
        .google-form-style h6 {
            text-align: center;
            font-weight: 700;
        }

        .google-form-style label {
            font-weight: 500;
        }

        .form-check-input:checked {
            background-color: #1a73e8;
            border-color: #1a73e8;
        }

        .form-control:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 0.2rem rgba(26, 115, 232, 0.25);
        }

        .btn i {
            vertical-align: middle;
        }

        .container {
            padding-top: 2rem;
            padding-bottom: 2rem;
        } */

        /* Wave loader */
        .wave-loader {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .wave-loader span {
            display: block;
            width: 5px;
            height: 20px;
            margin: 0 3px;
            background: #0d6efd;
            animation: wave 1.2s infinite ease-in-out;
        }
        .wave-loader span:nth-child(2) { animation-delay: -1.1s; }
        .wave-loader span:nth-child(3) { animation-delay: -1.0s; }
        .wave-loader span:nth-child(4) { animation-delay: -0.9s; }
        .wave-loader span:nth-child(5) { animation-delay: -0.8s; }

        @keyframes wave {
            0%, 40%, 100% { transform: scaleY(0.4); }
            20% { transform: scaleY(1); }
        }

        #loading-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: 1050;
            background: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <!-- Loading overlay -->
    <div id="loading-overlay">
        <div class="wave-loader">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
    </div>

    <!-- Nội dung chính -->
    <div class="container">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- JS Libraries -->
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hicolor.js') }}"></script>
    <script src="{{ asset('assets/admin/js/light/on-off.js') }}"></script>
    <script src="{{ asset('assets/admin/js/filter.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/tables/datatables/datatables.min.js') }}"></script>

    <!-- NProgress -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const links = document.querySelectorAll("a[href]:not([target='_blank']):not([href^='#']):not([href^='javascript'])");

            links.forEach(link => {
                link.addEventListener("click", function (e) {
                    const href = link.getAttribute("href");
                    if (href && !href.startsWith("#") && !href.startsWith("javascript")) {
                        NProgress.start();
                        document.getElementById("loading-overlay").style.display = "flex";
                    }
                });
            });

            window.addEventListener("pageshow", function () {
                NProgress.done();
                document.getElementById("loading-overlay").style.display = "none";
            });
        });
    </script>

    @stack('script')
</body>

</html>

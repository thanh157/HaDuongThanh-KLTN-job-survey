<!doctype html>
<html lang="en">

@include('admin.includes.head')

<body>
    <!--Main navbar-->
    @include('admin.includes.header')
    <!--/Main navbar-->

    <!-- Loading overlay -->
    <div id="loading-overlay" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;z-index:1050;background:rgba(255,255,255,0.8);display:flex;align-items:center;justify-content:center;">
        <div class="wave-loader">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
    </div>
    <!-- CSS hiệu ứng -->
    <style>
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
        table thead tr td {
            font-weight: 600;
        }

        .wave-loader span:nth-child(2) { animation-delay: -1.1s; }
        .wave-loader span:nth-child(3) { animation-delay: -1.0s; }
        .wave-loader span:nth-child(4) { animation-delay: -0.9s; }
        .wave-loader span:nth-child(5) { animation-delay: -0.8s; }

        @keyframes wave {
            0%, 40%, 100% { transform: scaleY(0.4); }
            20% { transform: scaleY(1); }
        }
    </style>

    <!-- Page content -->
    <div class="page-content">

        @include('admin.includes.sidebars')

        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Inner content -->
            <div class="content-inner">

                {{-- @include('admin.includes.toast') --}}

                @yield('content')

                <!-- Footer -->
                @include('admin.includes.footer')
                <!-- /footer -->
            </div>
            <!-- /inner content -->
        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    <!-- NProgress -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" rel="stylesheet" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('admin.includes.script')



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

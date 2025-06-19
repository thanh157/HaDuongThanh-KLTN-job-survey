<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Hệ thống thông tin cựu sinh viên</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e9f7fe, #ffffff);
            overflow-x: hidden;
        }

        .header {
            text-align: center;
            padding: 40px 20px 20px;
            position: relative;
            z-index: 2;
        }

        .logo-row img {
            height: 55px;
            margin: 0 10px;
        }

        .header h5 {
            margin-top: 15px;
            color: #444;
        }

        .header h3 {
            font-weight: 700;
            color: #0056b3;
        }

        .login-wrapper {
            max-width: 1000px;
            margin: 30px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        .login-image {
            flex: 1;
            background: #f1f4f8;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .login-image img {
            max-width: 100%;
            height: auto;
        }

        .login-form {
            flex: 1;
            padding: 50px 40px;
        }

        .login-form h5 {
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group i {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #999;
            font-size: 1.1rem;
        }

        .form-control {
            padding-left: 40px;
            border-radius: 10px;
            height: 44px;
        }

        .btn-login {
            width: 100%;
            border-radius: 10px;
            padding: 10px;
            background-color: #007bff;
            border: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .note {
            font-size: 0.875rem;
            color: #666;
            margin-top: 20px;
            text-align: justify;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-image,
            .login-form {
                padding: 30px 20px;
            }
        }

        .falling-icons {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }

        .falling-icons i {
            position: absolute;
            color: #007bff;
            font-size: 1.2rem;
            opacity: 0.8;
            animation: fall linear infinite;
        }

        @keyframes fall {
            0% {
                transform: translateY(-10%) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            100% {
                transform: translateY(110vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Loader CSS */
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

        .wave-loader span:nth-child(2) {
            animation-delay: -1.1s;
        }

        .wave-loader span:nth-child(3) {
            animation-delay: -1.0s;
        }

        .wave-loader span:nth-child(4) {
            animation-delay: -0.9s;
        }

        .wave-loader span:nth-child(5) {
            animation-delay: -0.8s;
        }

        @keyframes wave {
            0%,
            40%,
            100% {
                transform: scaleY(0.4);
            }

            20% {
                transform: scaleY(1);
            }
        }
    </style>
</head>

<body>

    <!-- Hiệu ứng icon rơi -->
    <div class="falling-icons" id="falling-icons"></div>

    <!-- Overlay loading -->
    <div id="loading-overlay"
        style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;z-index:1050;background:rgba(255,255,255,0.8);display:flex;align-items:center;justify-content:center;">
        <div class="wave-loader">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
    </div>

    <div class="header">
        <div class="logo-row mb-3">
            <img src="{{ asset('assets/admin/images/logo_vnua.png') }}" alt="Logo VNua">
            <img src="{{ asset('assets/admin/images/logoST.jpg') }}" alt="Logo ST">
            <img src="{{ asset('assets/admin/images/th.jpg') }}" alt="Logo TH">
        </div>
        <h5>Khoa Công nghệ thông tin - Học viện Nông Nghiệp Việt Nam</h5>
        <h3>Hệ thống quản lý sinh viên trực tuyến</h3>
    </div>

    <div class="login-wrapper">
        <div class="login-image">
            <img src="{{ asset('assets/admin/images/login.png') }}" alt="Login Illustration">
        </div>

        <div class="login-form">
            <h5>Đăng nhập hệ thống</h5>
            <a href="{{ route('sso.redirect') }}" class="btn btn-outline-primary w-100 mb-3">
                Đăng nhập với SSO
            </a>
            <form method="POST" action="#">
                @csrf
                <div class="form-group">
                    <i class="bi bi-person-fill"></i>
                    <input type="text" name="email" class="form-control" placeholder="Tài khoản / Email">
                </div>
                <div class="form-group">
                    <i class="bi bi-lock-fill"></i>
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                </div>

                <div class="text-end mb-3">
                    <a href="/quen-mat-khau" class="text-decoration-none" style="font-size: 0.9rem; color: #007bff;">
                        <i class="bi bi-question-circle"></i> Quên mật khẩu?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary btn-login">Đăng nhập</button>
            </form>
            <p class="note">
                Lưu ý: Hệ thống quản lý sinh viên dành cho ban chủ nhiệm khoa, cán bộ, giảng viên của từng khoa.
                Nếu bạn chưa có tài khoản, vui lòng liên hệ quản lý khoa hoặc quản trị hệ thống để thiết lập tài khoản.
            </p>
        </div>
    </div>

    <!-- NProgress -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" rel="stylesheet" />

    <script>
        const icons = ['bi-book', 'bi-pencil', 'bi-mortarboard', 'bi-journal-text', 'bi-award-fill'];
        const container = document.getElementById('falling-icons');

        function createIcon() {
            const icon = document.createElement('i');
            icon.className = 'bi ' + icons[Math.floor(Math.random() * icons.length)];
            icon.style.left = Math.random() * 100 + 'vw';
            icon.style.animationDuration = (Math.random() * 3 + 5) + 's';
            icon.style.fontSize = (Math.random() * 10 + 15) + 'px';
            container.appendChild(icon);
            setTimeout(() => container.removeChild(icon), 10000);
        }

        setInterval(createIcon, 1000);

        // Loading overlay và NProgress khi submit
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form");
            if (form) {
                form.addEventListener("submit", function () {
                    NProgress.start();
                    document.getElementById("loading-overlay").style.display = "flex";
                });
            }

            const links = document.querySelectorAll("a[href]:not([target='_blank']):not([href^='#']):not([href^='javascript'])");
            links.forEach(link => {
                link.addEventListener("click", function () {
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

</body>

</html>

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

        /* --- Hiệu ứng icon rơi --- */
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
    </style>
</head>

<body>

    <!-- Hiệu ứng icon rơi -->
    <div class="falling-icons" id="falling-icons"></div>

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
    </script>

</body>

</html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- ✅ Sửa dòng title này --}}
    <title>@yield('title', 'Hệ thống thông tin cựu sinh viên') | Hệ thống thông tin cựu sinh viên</title>

    <link rel="shortcut icon" href="{{ asset('assets/admin/images/logo_vnua.png') }}" type="image/x-icon">
    @include('admin.includes.script')
    @include('admin.includes.style')
    @stack('css')
</head>

@extends('admin.layouts.no-master')

@section('title', 'Cảm ơn bạn đã hoàn thành khảo sát')

@section('content')
    <style>
        .fade-in {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .bounce {
            animation: bounce 1.5s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }
    </style>

    <div class="container py-5 text-center fade-in">
        <h2 class="fw-bold text-success bounce">🎉 Cảm ơn bạn đã hoàn thành khảo sát!</h2>
        <p class="mt-3">Thông tin của bạn đã được ghi nhận thành công.</p>
    </div>
@endsection

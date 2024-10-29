@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <h3 class="mb-4">لوحة التحكم</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">العمليات الناجحة</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $successfulOperations }}</h5>
                        <p class="card-text">إجمالي عدد العمليات الناجحة.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">العمال</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $workerCount }}</h5>
                        <p class="card-text">إجمالي عدد العمال.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">إجمالي الأرباح</div>
                    <div class="card-body">
                        <h5 class="card-title">${{ number_format($totalEarnings, 2) }}</h5>
                        <p class="card-text">إجمالي الأرباح من العمليات الناجحة.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">العمليات غير النشطة</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $inactiveOperations }}</h5>
                        <p class="card-text">إجمالي عدد العمليات غير النشطة.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a href="{{ route('users.index') }}" class="card text-white bg-secondary mb-3">
                    <div class="card-header">إجمالي المستخدمين</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalUsers }}</h5>
                        <p class="card-text">إجمالي عدد المستخدمين.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">إجمالي المنتجات</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalProducts }}</h5>
                        <p class="card-text">إجمالي عدد المنتجات.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

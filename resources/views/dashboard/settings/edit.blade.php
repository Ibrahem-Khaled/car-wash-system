@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">تعديل بيانات الموقع</h1>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Errors Display --}}
        @if ($errors->any())
            <div class="alert alert-danger border-left-danger" role="alert">
                <ul class="pl-4 my-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">بيانات الموقع الأساسية</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Name -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">اسم الموقع/الشركة</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $settings->name) }}" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">البريد الإلكتروني للتواصل</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $settings->email) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Phone -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="phone">رقم الهاتف</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $settings->phone) }}">
                            </div>
                        </div>
                        <!-- City -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="city">المدينة</label>
                                <input type="text" class="form-control" id="city" name="city"
                                    value="{{ old('city', $settings->city) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="address">العنوان</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ old('address', $settings->address) }}">
                    </div>

                    <!-- Image -->
                    <div class="form-group">
                        <label for="image">شعار الموقع (اللوجو)</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                        <small class="form-text text-muted">اترك الحقل فارغاً للإبقاء على الشعار الحالي.</small>
                        @if ($settings->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $settings->image) }}" alt="الشعار الحالي"
                                    style="max-height: 80px; border-radius: 8px;">
                            </div>
                        @endif
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </form>
            </div>
        </div>
    </div>
@endsection

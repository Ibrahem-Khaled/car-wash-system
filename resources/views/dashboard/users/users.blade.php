@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>إدارة المستخدمين</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                إضافة مستخدم
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabs للتنقل بين الأدوار -->
        <ul class="nav nav-tabs mb-3" id="userTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-users-tab" data-bs-toggle="tab" data-bs-target="#all-users"
                    type="button" role="tab" aria-controls="all-users" aria-selected="true">كل المستخدمين</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="admin-users-tab" data-bs-toggle="tab" data-bs-target="#admin-users"
                    type="button" role="tab" aria-controls="admin-users" aria-selected="false">المسؤولين
                    (Admins)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="customer-users-tab" data-bs-toggle="tab" data-bs-target="#customer-users"
                    type="button" role="tab" aria-controls="customer-users" aria-selected="false">العملاء
                    (Customers)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="factor-users-tab" data-bs-toggle="tab" data-bs-target="#factor-users"
                    type="button" role="tab" aria-controls="factor-users" aria-selected="false">العاملين
                    (Factors)</button>
            </li>
        </ul>

        <div class="tab-content" id="userTabsContent">
            <!-- Tab كل المستخدمين -->
            <div class="tab-pane fade show active" id="all-users" role="tabpanel" aria-labelledby="all-users-tab">
                @include('dashboard.users.user_table', ['users' => $users])
            </div>

            <!-- Tab Admins -->
            <div class="tab-pane fade" id="admin-users" role="tabpanel" aria-labelledby="admin-users-tab">
                @include('dashboard.users.user_table', ['users' => $users->where('role', 'admin')])
            </div>

            <!-- Tab Customers -->
            <div class="tab-pane fade" id="customer-users" role="tabpanel" aria-labelledby="customer-users-tab">
                @include('dashboard.users.user_table', ['users' => $users->where('role', 'customer')])
            </div>

            <!-- Tab Factors -->
            <div class="tab-pane fade" id="factor-users" role="tabpanel" aria-labelledby="factor-users-tab">
                @include('dashboard.users.user_table', ['users' => $users->where('role', 'factor')])
            </div>
        </div>
    </div>

    <!-- Modal إضافة مستخدم -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">إضافة مستخدم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">العنوان</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">المدينة</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">الحالة</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active">نشط</option>
                                <option value="inactive">غير نشط</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">الدور</label>
                            <select class="form-control" id="role" name="role">
                                <option value="admin">مسؤول</option>
                                <option value="customer">عميل</option>
                                <option value="factor">عامل</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">صورة</label>
                            <input type="text" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

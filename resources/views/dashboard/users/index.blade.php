@extends('layouts.dashboard')

@section('title', 'إدارة المستخدمين')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">إدارة المستخدمين</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">لوحة التحكم</a></li>
                    <li class="breadcrumb-item active" aria-current="page">المستخدمين</li>
                </ol>
            </nav>
        </div>

        @include('components.alerts')

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fa-users" title="إجمالي المستخدمين" :value="$stats['total']" color="primary" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fa-user-check" title="المستخدمون النشطون" :value="$stats['active']" color="success" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fa-user-times" title="غير النشطين" :value="$stats['inactive']" color="danger" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fa-user-tag" title="عدد الأدوار" :value="$stats['roles_count']" color="warning" />
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 fw-bold text-primary">قائمة المستخدمين</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('customers.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus me-1"></i> إضافة عميل
                    </a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">
                        <i class="fas fa-plus me-1"></i> إضافة مستخدم
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link {{ $selectedRole === 'all' ? 'active' : '' }}"
                                href="{{ route('users.index') }}">الكل</a>
                        </li>
                        @foreach ($roles as $role)
                            <li class="nav-item">
                                <a class="nav-link {{ $selectedRole === $role ? 'active' : '' }}"
                                    href="{{ route('users.index', ['role' => $role]) }}">
                                    {{ $roleNames[$role] ?? ucfirst($role) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <form action="{{ route('users.index') }}" method="GET" style="width: 250px;">
                        <input type="hidden" name="role" value="{{ $selectedRole }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="بحث..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>المستخدم</th>
                                <th>التواصل</th>
                                <th>الدور</th>
                                <th>الحالة</th>
                                <th>تاريخ الإنشاء</th>
                                <th class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ Str::startsWith($user->image, 'http') ? $user->image : asset('storage/' . $user->image) }}"
                                                alt="{{ $user->name }}" class="rounded-circle me-2" width="45"
                                                height="45" style="object-fit: cover;">
                                            <div>
                                                <div class="fw-bold">{{ $user->name }}</div>
                                                <div class="small text-muted">{{ $user->city ?? 'غير محدد' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div><i class="fas fa-envelope text-muted me-1"></i> {{ $user->email ?? 'N/A' }}
                                        </div>
                                        <div><i class="fas fa-phone text-muted me-1"></i> {{ $user->phone }}</div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-info-subtle text-info-emphasis">{{ $roleNames[$user->role] ?? ucfirst($user->role) }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }}-subtle text-{{ $user->status == 'active' ? 'success' : 'danger' }}-emphasis">
                                            {{ $user->status == 'active' ? 'نشط' : 'غير نشط' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at?->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                                            data-target="#showUserModal{{ $user->id }}" title="عرض"><i
                                                class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                            data-target="#editUserModal{{ $user->id }}" title="تعديل"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                            data-target="#deleteUserModal{{ $user->id }}" title="حذف"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">لا توجد بيانات لعرضها.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('dashboard.users.modals.create')
    @foreach ($users as $user)
        @include('dashboard.users.modals.show')
        @include('dashboard.users.modals.edit')
        @include('dashboard.users.modals.delete')
    @endforeach

@endsection

@push('scripts')
    <script>
        // Script for image preview
        function previewImage(event, previewId) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById(previewId);
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush

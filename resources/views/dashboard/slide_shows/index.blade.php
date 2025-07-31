@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        {{-- عنوان الصفحة ومسار التنقل --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h1 class="h3 mb-0 text-gray-800">إدارة الشرائح</h1>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('home.dashboard') }}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">الشرائح</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @include('components.alerts')

        {{-- إحصائيات الشرائح --}}
        <div class="row mb-4">
            {{-- إجمالي الشرائح --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <x-stats-card icon="fas fa-images" title="إجمالي الشرائح" :value="$stats['total']" color="primary" />
            </div>
            {{-- الشرائح النشطة --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <x-stats-card icon="fas fa-check-circle" title="الشرائح النشطة" :value="$stats['active']" color="success" />
            </div>
            {{-- الشرائح غير النشطة --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <x-stats-card icon="fas fa-times-circle" title="الشرائح غير النشطة" :value="$stats['inactive']" color="danger" />
            </div>
        </div>

        {{-- بطاقة قائمة الشرائح --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">قائمة الشرائح</h6>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createSlideShowModal">
                    <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i> إضافة شريحة
                </button>
            </div>
            <div class="card-body">
                {{-- نموذج البحث --}}
                <form action="{{ route('slide_shows.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="ابحث بالعنوان أو الوصف..."
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>

                {{-- جدول الشرائح --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>العنوان</th>
                                <th>الحالة</th>
                                <th>الرابط</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($slideShows as $slideShow)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $slideShow->image) }}" alt="{{ $slideShow->title }}"
                                            class="img-thumbnail" width="100" style="height: 60px; object-fit: cover;">
                                    </td>
                                    <td>{{ $slideShow->title }}</td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $slideShow->status == 'active' ? 'success' : 'danger' }}">
                                            {{ $slideShow->status == 'active' ? 'نشط' : 'غير نشط' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($slideShow->link)
                                            <a href="{{ $slideShow->link }}" target="_blank" class="btn btn-sm btn-light">
                                                <i class="fas fa-link"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $slideShow->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        {{-- زر عرض --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="modal"
                                            data-target="#showSlideShowModal{{ $slideShow->id }}" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        {{-- زر تعديل --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-primary" data-toggle="modal"
                                            data-target="#editSlideShowModal{{ $slideShow->id }}" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        {{-- زر حذف --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="modal"
                                            data-target="#deleteSlideShowModal{{ $slideShow->id }}" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        {{-- تضمين المودالات لكل شريحة --}}
                                        @include('dashboard.slide_shows.modals.show')
                                        @include('dashboard.slide_shows.modals.edit')
                                        @include('dashboard.slide_shows.modals.delete')
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">لا توجد شرائح لعرضها حاليًا.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- الترقيم --}}
                <div class="d-flex justify-content-center">
                    {{ $slideShows->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- مودال إضافة شريحة جديد (ثابت) --}}
    @include('dashboard.slide_shows.modals.create')
@endsection

@push('scripts')
    {{-- Script لعرض اسم الملف المختار في حقول upload --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script to display file name in custom file input
            $('.custom-file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });

            // Enable Bootstrap tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush

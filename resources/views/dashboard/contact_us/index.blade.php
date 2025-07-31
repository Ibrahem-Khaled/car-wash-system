@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        {{-- عنوان الصفحة ومسار التنقل --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h1 class="h3 mb-0 text-gray-800">رسائل اتصل بنا</h1>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('home.dashboard') }}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">رسائل اتصل بنا</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @include('components.alerts')

        {{-- إحصائيات الرسائل --}}
        <div class="row mb-4">
            <div class="col-xl-6 col-md-6 mb-4">
                <x-stats-card icon="fas fa-envelope-open-text" title="إجمالي الرسائل" :value="$stats['total']" color="info" />
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <x-stats-card icon="fas fa-calendar-day" title="رسائل اليوم" :value="$stats['today']" color="success" />
            </div>
        </div>

        {{-- بطاقة قائمة الرسائل --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">قائمة الرسائل المستلمة</h6>
            </div>
            <div class="card-body">
                {{-- نموذج البحث --}}
                <form action="{{ route('contact-us.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="ابحث بالاسم، البريد الإلكتروني، أو الهاتف..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>

                {{-- جدول الرسائل --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الهاتف</th>
                                <th>تاريخ الإرسال</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->phone }}</td>
                                    <td>{{ $message->created_at->format('Y-m-d h:i A') }}</td>
                                    <td>
                                        {{-- زر عرض --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="modal"
                                            data-target="#showMessageModal{{ $message->id }}" title="عرض الرسالة">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        {{-- زر حذف --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="modal"
                                            data-target="#deleteMessageModal{{ $message->id }}" title="حذف الرسالة">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        {{-- تضمين المودالات لكل رسالة --}}
                                        @include('dashboard.contact_us.modals.show', [
                                            'message' => $message,
                                        ])
                                        @include('dashboard.contact_us.modals.delete', [
                                            'message' => $message,
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">لا توجد رسائل لعرضها.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- الترقيم --}}
                <div class="d-flex justify-content-center">
                    {{ $messages->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // تفعيل التولتيب
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush

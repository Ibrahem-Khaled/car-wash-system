@extends('layouts.dashboard')

@section('content')
    <div class="container" dir="rtl">
        <h1>الإشعارات</h1>

        <!-- زر لتفعيل نافذة إضافة الإشعار -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createNotificationModal">
            إضافة إشعار
        </button>

        <!-- جدول الإشعارات -->
        <table class="table">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>الوصف</th>
                    <th>الصورة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $notification)
                    <tr>
                        <td>{{ $notification->title }}</td>
                        <td>{{ $notification->description }}</td>
                        <td><img src="{{ asset('storage/' . $notification->image) }}" alt="{{ $notification->title }}" width="50"></td>
                        <td>
                            <!-- زر تعديل -->
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#editNotificationModal{{ $notification->id }}">
                                تعديل
                            </button>

                            <!-- فورم الحذف -->
                            <form action="{{ route('notifications.destroy', $notification) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>

                    <!-- نافذة تعديل الإشعار -->
                    <div class="modal fade" id="editNotificationModal{{ $notification->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="editNotificationModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('notifications.update', $notification) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editNotificationModalLabel">تعديل الإشعار</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title">العنوان</label>
                                            <input type="text" class="form-control" name="title"
                                                value="{{ $notification->title }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">الوصف</label>
                                            <textarea class="form-control" name="description" required>{{ $notification->description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">الصورة</label>
                                            <input type="file" class="form-control" name="image">
                                            <img src="{{ asset('storage/' . $notification->image) }}" width="50">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                        <button type="submit" class="btn btn-primary">تحديث</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- نافذة إضافة الإشعار -->
    <div class="modal fade" id="createNotificationModal" tabindex="-1" role="dialog"
        aria-labelledby="createNotificationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('notifications.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createNotificationModalLabel">إضافة إشعار</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">العنوان</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">الوصف</label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">الصورة</label>
                            <input type="file" class="form-control" name="image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

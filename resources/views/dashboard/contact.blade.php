@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">إدارة رسائل تواصل معنا</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- زر إضافة رسالة جديدة -->
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addContactModal">
            إضافة رسالة جديدة
        </button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الهاتف</th>
                    <th>الرسالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact?->name }}</td>
                        <td>{{ $contact?->email }}</td>
                        <td>{{ $contact?->phone }}</td>
                        <td>{{ $contact?->message }}</td>
                        <td>
                            <button class="btn btn-warning" data-toggle="modal"
                                data-target="#editContactModal{{ $contact->id }}">
                                تعديل
                            </button>
                            <button class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteContactModal{{ $contact->id }}">
                                حذف
                            </button>
                        </td>
                    </tr>

                    <!-- Edit Contact Modal -->
                    <div class="modal fade" id="editContactModal{{ $contact->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">تعديل الرسالة</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('contact-us.update', $contact->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="name">الاسم</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $contact->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email">البريد الإلكتروني</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $contact->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone">الهاتف</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ $contact->phone }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="message">الرسالة</label>
                                            <textarea class="form-control" name="message" rows="4" required>{{ $contact->message }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteContactModal{{ $contact->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">تأكيد الحذف</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>هل أنت متأكد أنك تريد حذف هذه الرسالة؟</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('contact-us.destroy', $contact->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Contact Modal -->
    <div class="modal fade" id="addContactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة رسالة جديدة</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('contact-us.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name">الاسم</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email">البريد الإلكتروني</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone">الهاتف</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="message">الرسالة</label>
                            <textarea class="form-control" name="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">إرسال</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

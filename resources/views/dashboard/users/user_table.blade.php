<table class="table table-striped">
    <thead class="bg-primary text-white">
        <tr>
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>الهاتف</th>
            <th>خط العرض</th>
            <th>خط الطول</th>
            <th>العنوان</th>
            <th>المدينة</th>
            <th>الحالة</th>
            <th>الدور</th>
            <th>الصورة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->latitude }}</td>
                <td>{{ $user->longitude }}</td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->city }}</td>
                <td>{{ $user->status }}</td>
                <td>{{ $user->role }}</td>
                <td><img src="{{ $user->image }}" alt="User Image" width="50"></td>
                <td>
                    <!-- زر تعديل المستخدم -->
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#editUserModal{{ $user->id }}">
                        تعديل
                    </button>

                    <!-- زر حذف المستخدم -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteUserModal{{ $user->id }}">
                        حذف
                    </button>
                </td>
            </tr>

            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">تعديل مستخدم</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">الاسم</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $user->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">الهاتف</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $user->phone }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete User Confirmation Modal -->
            <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1"
                aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel">تأكيد الحذف</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>هل أنت متأكد أنك تريد حذف المستخدم <strong>{{ $user->name }}</strong>؟</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>

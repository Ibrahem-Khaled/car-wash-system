<table class="table table-striped">
    <thead class="bg-primary text-white">
        <tr>
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>الهاتف</th>
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
                    @if ($user->role != 'admin' && $user->role != 'company')
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteUserModal{{ $user->id }}">
                            حذف
                        </button>
                    @endif
                </td>
            </tr>

            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">تعديل مستخدم</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
                                <div class="mb-3">
                                    <label for="address" class="form-label">العنوان</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ $user->address }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">المدينة</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        value="{{ $user->city }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">الحالة</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>نشط
                                        </option>
                                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>
                                            غير
                                            نشط</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">الدور</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="company" {{ $user->role == 'company' ? 'selected' : '' }}>الشركة
                                        </option>
                                        <option value="supervisor" {{ $user->role == 'supervisor' ? 'selected' : '' }}>
                                            مشرف
                                        </option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>مسؤول
                                        </option>
                                        <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>عميل
                                        </option>
                                        <option value="factor" {{ $user->role == 'factor' ? 'selected' : '' }}>عامل
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">صورة</label>
                                    <input type="text" class="form-control" id="image" name="image"
                                        value="{{ $user->image }}">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">كلمة المرور</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="اتركه فارغًا إذا لم ترغب في تغييره">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">إغلاق</button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>هل أنت متأكد أنك تريد حذف المستخدم <strong>{{ $user->name }}</strong>؟</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">إلغاء</button>
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>

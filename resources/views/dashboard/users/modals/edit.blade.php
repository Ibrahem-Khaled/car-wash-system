<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
    aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">تعديل: {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone"
                                value="{{ old('phone', $user->phone) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">النقاط</label>
                            <input type="number" step="0.01" class="form-control" name="points"
                                value="{{ old('points', $user->points) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">العنوان</label>
                            <input type="text" class="form-control" name="address"
                                value="{{ old('address', $user->address) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المدينة</label>
                            <input type="text" class="form-control" name="city"
                                value="{{ old('city', $user->city) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">كلمة المرور الجديدة</label>
                            <input type="password" class="form-control" name="password"
                                placeholder="اتركه فارغاً لعدم التغيير">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">الدور <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" required>
                                @foreach ($roleNames as $key => $value)
                                    <option value="{{ $key }}" @selected($user->role == $key)>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الحالة <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="active" @selected($user->status == 'active')>نشط</option>
                                <option value="inactive" @selected($user->status == 'inactive')>غير نشط</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="edit_image_{{ $user->id }}" class="form-label">تغيير الصورة</label>
                            <input type="file" class="form-control" name="image"
                                id="edit_image_{{ $user->id }}"
                                onchange="previewImage(event, 'editImagePreview{{ $user->id }}')">
                            <img id="editImagePreview{{ $user->id }}"
                                src="{{ Str::startsWith($user->image, 'http') ? $user->image : asset('storage/' . $user->image) }}"
                                alt="صورة المستخدم" class="mt-2 rounded" style="max-height: 100px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>

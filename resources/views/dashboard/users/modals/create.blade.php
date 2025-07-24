<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">إضافة مستخدم جديد</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">الاسم الكامل <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">رقم الهاتف <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="points" class="form-label">النقاط</label>
                            <input type="number" step="0.01" class="form-control" name="points" value="0.00">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">العنوان</label>
                            <input type="text" class="form-control" name="address">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">المدينة</label>
                            <input type="text" class="form-control" name="city">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">كلمة المرور <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">الدور <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" required>
                                @foreach ($roleNames as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="active" selected>نشط</option>
                                <option value="inactive">غير نشط</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="create_image" class="form-label">صورة المستخدم</label>
                            <input type="file" class="form-control" name="image" id="create_image"
                                onchange="previewImage(event, 'createImagePreview')">
                            <img id="createImagePreview" src="#" alt="معاينة الصورة" class="mt-2 rounded"
                                style="display:none; max-height: 100px;">
                        </div>
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

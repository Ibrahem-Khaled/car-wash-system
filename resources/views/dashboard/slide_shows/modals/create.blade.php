<div class="modal fade" id="createSlideShowModal" tabindex="-1" role="dialog" aria-labelledby="createSlideShowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSlideShowModalLabel">إضافة شريحة جديدة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('slide_shows.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">العنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">الوصف</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="link">الرابط (اختياري)</label>
                        <input type="url" class="form-control" id="link" name="link"
                            placeholder="https://example.com">
                    </div>
                    <div class="form-group">
                        <label for="status">الحالة <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active" selected>نشط</option>
                            <option value="inactive">غير نشط</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>صورة الشريحة <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image" required>
                            <label class="custom-file-label" for="image">اختر صورة...</label>
                        </div>
                        <small class="form-text text-muted">الأبعاد الموصى بها: 1920x800 بكسل</small>
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

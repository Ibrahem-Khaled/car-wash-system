<div class="modal fade" id="editSlideShowModal{{ $slideShow->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editSlideShowModalLabel{{ $slideShow->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSlideShowModalLabel{{ $slideShow->id }}">تعديل الشريحة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('slide_shows.update', $slideShow->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title{{ $slideShow->id }}">العنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title{{ $slideShow->id }}" name="title"
                            value="{{ $slideShow->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description{{ $slideShow->id }}">الوصف</label>
                        <textarea class="form-control" id="description{{ $slideShow->id }}" name="description" rows="3">{{ $slideShow->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="link{{ $slideShow->id }}">الرابط (اختياري)</label>
                        <input type="url" class="form-control" id="link{{ $slideShow->id }}" name="link"
                            value="{{ $slideShow->link }}" placeholder="https://example.com">
                    </div>
                    <div class="form-group">
                        <label for="status{{ $slideShow->id }}">الحالة <span class="text-danger">*</span></label>
                        <select class="form-control" id="status{{ $slideShow->id }}" name="status" required>
                            <option value="active" {{ $slideShow->status == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ $slideShow->status == 'inactive' ? 'selected' : '' }}>غير نشط
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>الصورة الحالية</label>
                        <div>
                            <img src="{{ asset('storage/' . $slideShow->image) }}" alt="{{ $slideShow->title }}"
                                class="img-thumbnail mb-2" width="150">
                        </div>
                        <label>تغيير الصورة (اختياري)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image{{ $slideShow->id }}"
                                name="image">
                            <label class="custom-file-label" for="image{{ $slideShow->id }}">اختر صورة جديدة...</label>
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

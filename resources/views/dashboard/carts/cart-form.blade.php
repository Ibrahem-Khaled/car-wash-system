<div class="modal-body">
    <div class="mb-3">
        <label for="customer_id" class="form-label">العميل</label>
        <select class="form-control" id="customer_id" name="customer_id" required>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="factor_id" class="form-label">العامل</label>
        <select class="form-control" id="factor_id" name="factor_id">
            <option value="">غير متوفر</option>
            @foreach ($factors as $factor)
                <option value="{{ $factor->id }}">{{ $factor->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="product_id" class="form-label">المنتج</label>
        <select class="form-control" id="product_id" name="product_id" required>
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="car_model" class="form-label">موديل السيارة</label>
        <select class="form-control" id="car_model" name="car_model">
            <option value="">غير متوفر</option>
            @foreach ($cars as $car)
                <option value="{{ $car->id }}">{{ $car->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="car_color" class="form-label">لون السيارة</label>
        <select class="form-control" id="car_color" name="car_color">
            <option value="أسود">أسود</option>
            <option value="أبيض">أبيض</option>
            <option value="أحمر">أحمر</option>
            <option value="أزرق">أزرق</option>
            <option value="رمادي">رمادي</option>
            <option value="فضي">فضي</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="car_number" class="form-label">رقم السيارة</label>
        <input type="text" class="form-control" id="car_number" name="car_number">
    </div>

    <div class="mb-3">
        <label for="car_wash" class="form-label">تاريخ ووقت الغسيل</label>
        <input type="datetime-local" class="form-control" id="car_wash" name="car_wash">
    </div>

    <div class="mb-3">
        <label for="car_type" class="form-label">نوع السيارة</label>
        <select class="form-control" id="car_type" name="car_type" required>
            <option value="small">صغيرة</option>
            <option value="medium">متوسطة</option>
            <option value="large">كبيرة</option>
            <option value="x_large">كبيرة جدا</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="latitude" class="form-label">خط العرض</label>
        <input type="text" class="form-control" id="latitude" name="latitude">
    </div>

    <div class="mb-3">
        <label for="longitude" class="form-label">خط الطول</label>
        <input type="text" class="form-control" id="longitude" name="longitude">
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">السعر</label>
        <input type="number" class="form-control" id="price" name="price" required>
    </div>

    <div class="mb-3">
        <label for="decline_reason" class="form-label">سبب الرفض (إن وجد)</label>
        <textarea class="form-control" id="decline_reason" name="decline_reason" rows="2"></textarea>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
    <button type="submit" class="btn btn-primary">حفظ</button>
</div>

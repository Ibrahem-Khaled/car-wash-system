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
            @foreach ($cars as $car)
                <option value="{{ $car->id }}">{{ $car->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="car_color" class="form-label">لون السيارة</label>
        <input type="text" class="form-control" id="car_color" name="car_color">
    </div>
    <div class="mb-3">
        <label for="car_number" class="form-label">رقم السيارة</label>
        <input type="text" class="form-control" id="car_number" name="car_number">
    </div>
    <div class="mb-3">
        <label for="car_wash" class="form-label">تاريخ الغسيل</label>
        <input type="datetime-local" class="form-control" id="car_wash" name="car_wash">
    </div>
    <div class="mb-3">
        <label for="car_type" class="form-label">نوع السيارة</label>
        <select class="form-control" id="car_type" name="car_type">
            <option value="small">صغيرة</option>
            <option value="medium">متوسطة</option>
            <option value="large">كبيرة</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">السعر</label>
        <input type="number" class="form-control" id="price" name="price">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
    <button type="submit" class="btn btn-primary">حفظ</button>
</div>

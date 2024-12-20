<div class="col-md-6">
    <div class="order-card bg-white">
        <h5>طلب رقم #{{ $item->id }}</h5>
        <p><strong>المنتج:</strong> {{ optional($item->product)->name }}</p>
        <p><strong>السعر:</strong> {{ $item->price }} ريال</p>
        <p><strong>حجم السيارة:</strong> {{ $item->car_type }}</p>
        <p><strong>موديل السيارة:</strong> {{ $item->car->name }}</p>
        <p><strong>لون السيارة:</strong> {{ $item->car_color }}</p>
        <p><strong>رقم السيارة:</strong> {{ $item->car_number }}</p>
        <p><strong>تاريخ الغسيل:</strong> {{ $item->car_wash }}</p>
        <p><strong>الإحداثيات:</strong> {{ $item->latitude }}, {{ $item->longitude }}</p>

        <!-- بيانات العميل -->
        <div class="customer-info mt-3">
            <h6>بيانات العميل:</h6>
            <p><strong>الاسم:</strong> {{ optional($item->customer)->name ?? 'غير متوفر' }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ optional($item->customer)->email ?? 'غير متوفر' }}</p>
            <p><strong>رقم الهاتف:</strong> {{ optional($item->customer)->phone ?? 'غير متوفر' }}</p>
        </div>

        <!-- التحقق وعرض التقييم -->
        @if ($item->reviews->isNotEmpty())
            <div class="review-info mt-3">
                <h6>تقييم الطلب:</h6>
                @foreach ($item->reviews as $review)
                    <p><strong>التقييم:</strong> {{ $review->rating }} من 5</p>
                    <p><strong>التعليق:</strong> {{ $review->comment }}</p>
                @endforeach
            </div>
        @endif

        @if ($item->status !== 'completed')
            <form action="{{ route('updateOrderStatus', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <p>تغيير حالة الطلب:</p>
                    @if ($item->status == 'declined' && auth()->user()->role == 'supervisor')
                        <button class="btn btn-success" name="status" value="pending" type="submit">تحويل الطلب</button>
                    @elseif ($item->status == 'pending' && auth()->user()->role == 'factor')
                        <button class="btn btn-warning" name="status" value="acepted" type="submit">قبول</button>
                    @elseif ($item->status == 'acepted' && auth()->user()->role == 'factor')
                        <button class="btn btn-success" name="status" value="completed" type="submit">استكمال
                            الطلب</button>
                    @endif
                    @if (auth()->user()->role == 'factor')
                        <button class="btn btn-danger" type="button" id="declineButton">ارجاع الطلب</button>
                    @endif
                </div>

                <div class="mb-3" id="reasonContainer" style="display: none;">
                    <label for="decline_reason" class="form-label">سبب الارجاع</label>
                    <textarea class="form-control" name="decline_reason" id="decline_reason" rows="3"></textarea>
                    <button class="btn btn-danger mt-2" name="status" value="declined" type="submit">تأكيد
                        الارجاع</button>
                </div>

                @if (Auth::check() && !in_array(auth()->user()->role, ['factor', 'company', 'customer']))
                    <div class="mb-3">
                        <label for="worker_id" class="form-label">تحديد العامل المسؤول</label>
                        <select class="form-select" name="worker_id" id="worker_id" required>
                            <option value="">-- اختر العامل --</option>
                            @foreach ($workers as $worker)
                                <option value="{{ $worker->id }}"
                                    {{ $item->worker_id == $worker->id ? 'selected' : '' }}>
                                    {{ $worker->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-success mt-3" type="submit" value="pending" name="status">تحديد العامل
                        الجديد</button>
                @endif


            </form>
            @if (Auth::check() && $item->status == 'acepted' && $item->paid == 'cash_on_delivery')
                <form action="{{ route('user.carts.addReferenceNumber') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">طريقة الدفع</label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method"
                            name="payment_method" required>
                            <option value="cash_on_delivery">كاش</option>
                            <option value="mada"
                                {{ old('payment_method', $item->reference_number !== null ? 'mada' : '') == 'mada' ? 'selected' : '' }}>
                                مدى</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="reference_number_container" style="display: none;">
                        <label for="reference_number" class="form-label">رقم المرجعي</label>
                        <input type="text" class="form-control @error('reference_number') is-invalid @enderror"
                            id="reference_number" name="reference_number"
                            value="{{ old('reference_number', $item?->reference_number ?? '') }}">
                        <input type="hidden" name="cart_id" value="{{ $item->id }}">
                        @error('reference_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" id="submit_button">حفظ الطلب</button>
                </form>
            @endif
        @endif

        <button class="btn btn-secondary mt-3" onclick="openMap({{ $item->latitude }}, {{ $item->longitude }})">عرض
            الموقع على الخريطة</button>
    </div>
</div>

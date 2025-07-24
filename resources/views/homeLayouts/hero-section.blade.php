<section class="py-5 bg-light">
    <div class="container">
        <div id="productCarousel" class="carousel slide" data-ride="carousel">
            <!-- المؤشرات -->
            <div class="carousel-indicators">
                @foreach ($products as $key => $product)
                    <button type="button" data-target="#productCarousel" data-slide-to="{{ $key }}"
                        class="{{ $key === 0 ? 'active' : '' }}" aria-current="{{ $key === 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>

            <!-- الشرائح -->
            <div class="carousel-inner">
                @foreach ($products as $key => $product)
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="{{ asset('storage/' . $product->image) }}" class="d-block w-100 rounded"
                                    alt="{{ $product->name }}">
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 text-center text-md-end">
                                    <h3 class="text-primary">{{ $product->name }}</h3>
                                    <p class="text-secondary">{{ $product->description }}</p>

                                    <!-- قائمة الأسعار -->
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>سعر السيارة الصغيرة</span>
                                            <span class="badge bg-primary" style="background-color: #4a2f85;">
                                                {{ $product->small_car_price ?? 'غير متاح' }} ريال
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>سعر السيارة المتوسطة</span>
                                            <span class="badge bg-primary" style="background-color: #4a2f85;">
                                                {{ $product->medium_car_price ?? 'غير متاح' }} ريال
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>سعر السيارة الكبيرة</span>
                                            <span class="badge bg-primary" style="background-color: #4a2f85;">
                                                {{ $product->large_car_price ?? 'غير متاح' }} ريال
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>سعر السيارة الكبيرة جدًا</span>
                                            <span class="badge bg-primary" style="background-color: #4a2f85;">
                                                {{ $product->x_large_car_price ?? 'غير متاح' }} ريال
                                            </span>
                                        </li>
                                    </ul>

                                    <a href="{{ route('services') }}" class="btn btn-primary"
                                        style="background-color: #4a2f85;">طلب الآن</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- <!-- أدوات التنقل -->
            <button class="carousel-control-prev" type="button" data-target="#productCarousel" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">السابق</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#productCarousel" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">التالي</span>
            </button> --}}
        </div>
    </div>
</section>

@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>الخدمات</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
                إضافة خدمة
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>الاسم</th>
                        <th>الوصف</th>
                        <th>الصورة</th>
                        <th>النوع</th>
                        <th>سعر السيارة الصغيرة</th>
                        <th>سعر السيارة المتوسطة</th>
                        <th>سعر السيارة الكبيرة</th>
                        <th>سعر السيارة الكبيرة جدًا</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    width="50"></td>
                            <td>{{ $product->type }}</td>
                            <td>{{ $product->small_car_price }}</td>
                            <td>{{ $product->medium_car_price }}</td>
                            <td>{{ $product->large_car_price }}</td>
                            <td>{{ $product->x_large_car_price }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#editProductModal{{ $product->id }}">
                                    تعديل
                                </button>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>

                        <!-- نافذة تعديل المنتج -->
                        <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1"
                            aria-labelledby="editProductModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProductModalLabel">تعديل المنتج</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal"
                                            aria-label="إغلاق"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('products.update', $product->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="name" class="form-label">الاسم</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $product->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">الوصف</label>
                                                <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label">الصورة</label>
                                                <input type="file" class="form-control" id="image" name="image">
                                            </div>
                                            <div class="mb-3">
                                                <label for="type" class="form-label">النوع</label>
                                                <select class="form-control" id="type" name="type">
                                                    <option value="main"
                                                        {{ $product->type == 'main' ? 'selected' : '' }}>رئيسي</option>
                                                    <option value="sub" {{ $product->type == 'sub' ? 'selected' : '' }}>
                                                        فرعي</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="small_car_price" class="form-label">سعر السيارة الصغيرة</label>
                                                <input type="number" class="form-control" id="small_car_price"
                                                    name="small_car_price" value="{{ $product->small_car_price }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="medium_car_price" class="form-label">سعر السيارة
                                                    المتوسطة</label>
                                                <input type="number" class="form-control" id="medium_car_price"
                                                    name="medium_car_price" value="{{ $product->medium_car_price }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="large_car_price" class="form-label">سعر السيارة الكبيرة</label>
                                                <input type="number" class="form-control" id="large_car_price"
                                                    name="large_car_price" value="{{ $product->large_car_price }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="x_large_car_price" class="form-label">سعر السيارة الكبيرة
                                                    جدًا</label>
                                                <input type="number" class="form-control" id="x_large_car_price"
                                                    name="x_large_car_price" value="{{ $product->x_large_car_price }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">إغلاق</button>
                                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- نافذة إضافة منتج -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">إضافة منتج</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">الصورة</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">النوع</label>
                            <select class="form-control" id="type" name="type">
                                <option value="main">رئيسي</option>
                                <option value="sub">فرعي</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="small_car_price" class="form-label">سعر السيارة الصغيرة</label>
                            <input type="number" class="form-control" id="small_car_price" name="small_car_price">
                        </div>
                        <div class="mb-3">
                            <label for="medium_car_price" class="form-label">سعر السيارة المتوسطة</label>
                            <input type="number" class="form-control" id="medium_car_price" name="medium_car_price">
                        </div>
                        <div class="mb-3">
                            <label for="large_car_price" class="form-label">سعر السيارة الكبيرة</label>
                            <input type="number" class="form-control" id="large_car_price" name="large_car_price">
                        </div>
                        <div class="mb-3">
                            <label for="x_large_car_price" class="form-label">سعر السيارة الكبيرة
                                جدًا</label>
                            <input type="number" class="form-control" id="x_large_car_price" name="x_large_car_price">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

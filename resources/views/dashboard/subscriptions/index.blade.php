@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">الاشتراكات</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- زر إضافة اشتراك -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal">
            إضافة اشتراك جديد
        </button>

        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>الصورة</th>
                    <th>اسم الاشتراك</th>
                    <th>الوصف</th>
                    <th>السعر</th>
                    <th>المدة</th>
                    <th>الحالة</th>
                    <th>المنتجات</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $index => $subscription)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if ($subscription->image)
                                <img src="{{ asset('storage/' . $subscription->image) }}" alt="{{ $subscription->name }}"
                                    class="img-thumbnail" style="width: 100px; height: 100px;">
                            @else
                                <i class="fas fa-star package-icon" style="font-size: 2rem;"></i>
                            @endif
                        </td>
                        <td>{{ $subscription->name }}</td>
                        <td>{{ $subscription->description }}</td>
                        <td>{{ $subscription->price }} ريال / شهر</td>
                        <td>{{ $subscription->duration }} شهر</td>
                        <td>{{ $subscription->status ? 'مفعل' : 'غير مفعل' }}</td>
                        <td>
                            <ul class="list-unstyled" id="product-list-{{ $subscription->id }}">
                                @foreach ($subscription->products as $product)
                                    <li id="product-{{ $product->id }}">
                                        {{ $product->name }} - {{ $product->pivot->quantity }} قطعة
                                        <form
                                            action="{{ route('subscriptions.removeProduct', [$subscription->id, $product->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                حذف
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <!-- زر تعديل -->
                            <button class="btn btn-warning mb-1" data-bs-toggle="modal"
                                data-bs-target="#editSubscriptionModal-{{ $subscription->id }}">
                                تعديل
                            </button>

                            <!-- فورم الحذف -->
                            <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Subscription Modal -->
                    <div class="modal fade" id="editSubscriptionModal-{{ $subscription->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel-{{ $subscription->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel-{{ $subscription->id }}">تعديل الاشتراك</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST" action="{{ route('subscriptions.update', $subscription->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">اسم الاشتراك</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $subscription->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">الوصف</label>
                                            <textarea class="form-control" name="description">{{ $subscription->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">السعر</label>
                                            <input type="number" class="form-control" name="price"
                                                value="{{ $subscription->price }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">المدة</label>
                                            <input type="number" class="form-control" name="duration"
                                                value="{{ $subscription->duration }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">الحالة</label>
                                            <select class="form-select" name="status">
                                                <option value="1" {{ $subscription->status ? 'selected' : '' }}>مفعل
                                                </option>
                                                <option value="0" {{ !$subscription->status ? 'selected' : '' }}>غير
                                                    مفعل</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">المنتجات</label>
                                            @foreach ($products as $product)
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text">{{ $product->name }}</span>
                                                    <input type="number" class="form-control"
                                                        name="quantities[{{ $product->id }}]"
                                                        value="{{ $subscription->products->where('id', $product->id)->first()->pivot->quantity ?? 0 }}">
                                                    <input type="hidden" name="products[]" value="{{ $product->id }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ارفاق الصورة</label>
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                            @if ($subscription->image)
                                                <img src="{{ asset('storage/' . $subscription->image) }}" class="mt-2"
                                                    width="100" alt="الصورة">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">إغلاق</button>
                                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- Add Subscription Modal -->
        <div class="modal fade" id="addSubscriptionModal" tabindex="-1" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">إضافة اشتراك جديد</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('subscriptions.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">اسم الاشتراك</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الوصف</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">السعر</label>
                                <input type="number" class="form-control" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">المدة</label>
                                <input type="number" class="form-control" name="duration" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">المنتجات</label>
                                @foreach ($products as $product)
                                    <div class="input-group mb-2">
                                        <span class="input-group-text">{{ $product->name }}</span>
                                        <input type="number" class="form-control"
                                            name="quantities[{{ $product->id }}]" min="0" value="0">
                                        <input type="hidden" name="products[]" value="{{ $product->id }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ارفاق الصورة</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

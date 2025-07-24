@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>السلة</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCartModal">
                إضافة إلى السلة
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="cartTabs" role="tablist">
            @foreach ([
            'all' => 'كل الطلبات',
            'accepted' => 'الطلبات المقبولة',
            'declined' => 'الطلبات المرفوضة',
            'pending' => 'الطلبات المعلقة',
            'completed' => 'الطلبات المكتملة',
        ] as $key => $label)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $key }}-tab"
                        data-toggle="tab" data-target="#{{ $key }}" type="button" role="tab"
                        aria-controls="{{ $key }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $label }}
                    </button>
                </li>
            @endforeach
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="cartTabsContent">
            @foreach ([
            'all' => $carts,
            'accepted' => $carts->where('status', 'accepted'),
            'declined' => $carts->where('status', 'declined'),
            'pending' => $carts->where('status', 'pending'),
            'completed' => $carts->where('status', 'completed'),
        ] as $key => $cartList)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}" role="tabpanel"
                    aria-labelledby="{{ $key }}-tab">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>العميل</th>
                                    <th>العامل</th>
                                    <th>المنتج</th>
                                    <th>موديل السيارة</th>
                                    <th>لون السيارة</th>
                                    <th>رقم السيارة</th>
                                    <th>تاريخ الغسيل</th>
                                    <th>نوع السيارة</th>
                                    <th>السعر</th>
                                    <th>حالة الدفع</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartList as $cart)
                                    @include('dashboard.carts.cart-row', ['cart' => $cart])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('dashboard.carts.add-cart-modal')
@endsection

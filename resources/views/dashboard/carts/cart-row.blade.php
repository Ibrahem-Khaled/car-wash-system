<tr>
    <td>{{ $cart->id }}</td>
    <td>{{ $cart->customer->name }}</td>
    <td>{{ $cart->factor->name ?? 'غير متوفر' }}</td>
    <td>{{ $cart->product->name }}</td>
    <td>{{ $cart->car->name ?? 'غير متوفر' }}</td>
    <td>{{ $cart->car_color }}</td>
    <td>{{ $cart->car_number }}</td>
    <td>{{ $cart->car_wash }}</td>
    <td>{{ $cart->car_type }}</td>
    <td>{{ $cart->price }}</td>
    <td>
        @switch($cart->status)
            @case('acepted')
                <span class="badge bg-success">مقبول</span>
            @break

            @case('declined')
                <span class="badge bg-danger">مرفوض</span>
            @break

            @case('pending')
                <span class="badge bg-info">قيد التنفيذ</span>
            @break

            @case('unpaid')
                <span class="badge bg-warning">غير مدفوع</span>
            @break

            @case('paid_on_delivery')
                <span class="badge bg-primary">مدفوع عند التسليم</span>
            @break

            @case('completed')
                <span class="badge bg-success">مكتمل</span>
            @break

            @default
                <span class="badge bg-secondary">غير معروف</span>
        @endswitch
    </td>
    <td>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
            data-bs-target="#editCartModal{{ $cart->id }}">
            تعديل
        </button>
        <form action="{{ route('carts.destroy', $cart->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">حذف</button>
        </form>

        {{-- <form action="{{ route('dashboard.carts.updateStatus', [$cart->id, 'acepted']) }}" method="POST"
            class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">قبول</button>
        </form>

        <form action="{{ route('dashboard.carts.updateStatus', [$cart->id, 'pending']) }}" method="POST"
            class="d-inline">
            @csrf
            <button type="submit" class="btn btn-info">قيد التنفيذ</button>
        </form>

        <form action="{{ route('dashboard.carts.updateStatus', [$cart->id, 'completed']) }}" method="POST"
            class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">اكتمل</button>
        </form>

        <form action="{{ route('dashboard.carts.updateStatus', [$cart->id, 'paid_on_delivery']) }}" method="POST"
            class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary">مدفوع عند التسليم</button>
        </form>

        <form action="{{ route('dashboard.carts.updateStatus', [$cart->id, 'declined']) }}" method="POST"
            class="d-inline">
            @csrf
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                data-bs-target="#declineReasonModal{{ $cart->id }}">رفض</button>
        </form> --}}
    </td>
</tr>

@include('dashboard.carts.edit-cart-modal', ['cart' => $cart])

<!-- Modal لسبب الرفض -->
<div class="modal fade" id="declineReasonModal{{ $cart->id }}" tabindex="-1" aria-labelledby="declineReasonLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dashboard.carts.updateStatus', [$cart->id, 'declined']) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="declineReasonLabel">سبب الرفض</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" name="decline_reason" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-danger">رفض الطلب</button>
                </div>
            </form>
        </div>
    </div>
</div>

<tr>
    <td>{{ $cart->customer->name }}</td>
    <td>{{ $cart->factor->name ?? 'غير متوفر' }}</td>
    <td>{{ $cart->product->name }}</td>
    <td>{{ $cart->car->name ?? 'غير متوفر' }}</td>
    <td>{{ $cart->car_color }}</td>
    <td>{{ $cart->car_number }}</td>
    <td>{{ $cart->car_wash }}</td>
    <td>{{ $cart->status }}</td>
    <td>{{ $cart->car_type }}</td>
    <td>{{ $cart->price }}</td>
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
        <form action="{{ route('dashboard.carts.acceptOrder', $cart->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">قبول</button>
        </form>
        <form action="{{ route('dashboard.carts.declineOrder', $cart->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-secondary">رفض</button>
        </form>
    </td>
</tr>

@include('dashboard.carts.edit-cart-modal', ['cart' => $cart])
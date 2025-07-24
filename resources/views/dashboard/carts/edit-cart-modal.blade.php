<div class="modal fade" id="editCartModal{{ $cart->id }}" tabindex="-1" aria-labelledby="editCartModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCartModalLabel">تعديل السلة</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('carts.update', $cart->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('dashboard.carts.cart-form', ['cart' => $cart])
            </form>
        </div>
    </div>
</div>

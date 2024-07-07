@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Carts</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCartModal">
                Add Cart
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
                        <th>Customer</th>
                        <th>Factor</th>
                        <th>Product</th>
                        <th>Car Model</th>
                        <th>Car Color</th>
                        <th>Car Number</th>
                        <th>Car Wash</th>
                        <th>Status</th>
                        <th>Car Type</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carts as $cart)
                        <tr>
                            <td>{{ $cart->customer->name }}</td>
                            <td>{{ $cart->factor->name ?? 'N/A' }}</td>
                            <td>{{ $cart->product->name }}</td>
                            <td>{{ $cart->car->name ?? 'N/A' }}</td>
                            <td>{{ $cart->car_color }}</td>
                            <td>{{ $cart->car_number }}</td>
                            <td>{{ $cart->car_wash }}</td>
                            <td>{{ $cart->status }}</td>
                            <td>{{ $cart->car_type }}</td>
                            <td>{{ $cart->price }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editCartModal{{ $cart->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('carts.destroy', $cart->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                <form action="{{ route('dashboard.carts.acceptOrder', $cart->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>
                                <form action="{{ route('dashboard.carts.declineOrder', $cart->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary">Decline</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Cart Modal -->
                        <div class="modal fade" id="editCartModal{{ $cart->id }}" tabindex="-1"
                            aria-labelledby="editCartModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCartModalLabel">Edit Cart</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('carts.update', $cart->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="customer_id" class="form-label">Customer</label>
                                                <select class="form-control" id="customer_id" name="customer_id" required>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $cart->customer_id == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="factor_id" class="form-label">Factor</label>
                                                <select class="form-control" id="factor_id" name="factor_id">
                                                    <option value="">None</option>
                                                    @foreach ($factors as $factor)
                                                        <option value="{{ $factor->id }}"
                                                            {{ $cart->factor_id == $factor->id ? 'selected' : '' }}>
                                                            {{ $factor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_id" class="form-label">Product</label>
                                                <select class="form-control" id="product_id" name="product_id" required>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            {{ $cart->product_id == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="car_model" class="form-label">Car Model</label>
                                                <select class="form-control" id="car_model" name="car_model">
                                                    @foreach ($cars as $car)
                                                        <option value="{{ $car->id }}"
                                                            {{ $cart->car_model == $car->id ? 'selected' : '' }}>
                                                            {{ $car->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="car_color" class="form-label">Car Color</label>
                                                <input type="text" class="form-control" id="car_color" name="car_color"
                                                    value="{{ $cart->car_color }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="car_number" class="form-label">Car Number</label>
                                                <input type="text" class="form-control" id="car_number" name="car_number"
                                                    value="{{ $cart->car_number }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="car_wash" class="form-label">Car Wash</label>
                                                <input type="datetime-local" class="form-control" id="car_wash"
                                                    name="car_wash" value="{{ $cart->car_wash }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="active"
                                                        {{ $cart->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive"
                                                        {{ $cart->status == 'inactive' ? 'selected' : '' }}>Inactive
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="car_type" class="form-label">Car Type</label>
                                                <select class="form-control" id="car_type" name="car_type">
                                                    <option value="small"
                                                        {{ $cart->car_type == 'small' ? 'selected' : '' }}>Small</option>
                                                    <option value="medium"
                                                        {{ $cart->car_type == 'medium' ? 'selected' : '' }}>Medium</option>
                                                    <option value="large"
                                                        {{ $cart->car_type == 'large' ? 'selected' : '' }}>Large</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="number" class="form-control" id="price" name="price"
                                                    value="{{ $cart->price }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
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
                {{ $carts->links() }}
            </div>
        </div>
    </div>

    <!-- Add Cart Modal -->
    <div class="modal fade" id="addCartModal" tabindex="-1" aria-labelledby="addCartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCartModalLabel">Add Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('carts.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select class="form-control" id="customer_id" name="customer_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="factor_id" class="form-label">Factor</label>
                            <select class="form-control" id="factor_id" name="factor_id">
                                <option value="">None</option>
                                @foreach ($factors as $factor)
                                    <option value="{{ $factor->id }}">{{ $factor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Product</label>
                            <select class="form-control" id="product_id" name="product_id" required>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="car_model" class="form-label">Car Model</label>
                            <select class="form-control" id="car_model" name="car_model">
                                @foreach ($cars as $car)
                                    <option value="{{ $car->id }}">{{ $car->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="car_color" class="form-label">Car Color</label>
                            <input type="text" class="form-control" id="car_color" name="car_color">
                        </div>
                        <div class="mb-3">
                            <label for="car_number" class="form-label">Car Number</label>
                            <input type="text" class="form-control" id="car_number" name="car_number">
                        </div>
                        <div class="mb-3">
                            <label for="car_wash" class="form-label">Car Wash</label>
                            <input type="datetime-local" class="form-control" id="car_wash" name="car_wash">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="car_type" class="form-label">Car Type</label>
                            <select class="form-control" id="car_type" name="car_type">
                                <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

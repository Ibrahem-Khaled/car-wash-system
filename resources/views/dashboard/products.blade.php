@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Products</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Add Product
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
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Type</th>
                        <th>Parent</th>
                        <th>Small Car Price</th>
                        <th>Medium Car Price</th>
                        <th>Large Car Price</th>
                        <th>Actions</th>
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
                            <td>{{ $product->parent->name ?? 'N/A' }}</td>
                            <td>{{ $product->small_car_price }}</td>
                            <td>{{ $product->medium_car_price }}</td>
                            <td>{{ $product->large_car_price }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editProductModal{{ $product->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Product Modal -->
                        <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1"
                            aria-labelledby="editProductModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('products.update', $product->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $product->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" class="form-control" id="image" name="image">
                                            </div>
                                            <div class="mb-3">
                                                <label for="type" class="form-label">Type</label>
                                                <select class="form-control" id="type" name="type">
                                                    <option value="main"
                                                        {{ $product->type == 'main' ? 'selected' : '' }}>Main</option>
                                                    <option value="sub" {{ $product->type == 'sub' ? 'selected' : '' }}>
                                                        Sub</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="parent_id" class="form-label">Parent</label>
                                                <select class="form-control" id="parent_id" name="parent_id">
                                                    <option value="">None</option>
                                                    @foreach ($products as $parent)
                                                        <option value="{{ $parent->id }}"
                                                            {{ $product->parent_id == $parent->id ? 'selected' : '' }}>
                                                            {{ $parent->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="small_car_price" class="form-label">Small Car Price</label>
                                                <input type="number" class="form-control" id="small_car_price"
                                                    name="small_car_price" value="{{ $product->small_car_price }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="medium_car_price" class="form-label">Medium Car Price</label>
                                                <input type="number" class="form-control" id="medium_car_price"
                                                    name="medium_car_price" value="{{ $product->medium_car_price }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="large_car_price" class="form-label">Large Car Price</label>
                                                <input type="number" class="form-control" id="large_car_price"
                                                    name="large_car_price" value="{{ $product->large_car_price }}">
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
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="main">Main</option>
                                <option value="sub">Sub</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent</label>
                            <select class="form-control" id="parent_id" name="parent_id">
                                <option value="">None</option>
                                @foreach ($products as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="small_car_price" class="form-label">Small Car Price</label>
                            <input type="number" class="form-control" id="small_car_price" name="small_car_price">
                        </div>
                        <div class="mb-3">
                            <label for="medium_car_price" class="form-label">Medium Car Price</label>
                            <input type="number" class="form-control" id="medium_car_price" name="medium_car_price">
                        </div>
                        <div class="mb-3">
                            <label for="large_car_price" class="form-label">Large Car Price</label>
                            <input type="number" class="form-control" id="large_car_price" name="large_car_price">
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

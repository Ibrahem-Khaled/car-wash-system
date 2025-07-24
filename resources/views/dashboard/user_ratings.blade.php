@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>User Ratings</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRatingModal">
                Add Rating
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
                        <th>User</th>
                        <th>Factor</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ratings as $rating)
                        <tr>
                            <td>{{ $rating->user->name }}</td>
                            <td>{{ $rating->factor->name }}</td>
                            <td>{{ $rating->rating }}</td>
                            <td>{{ $rating->comment }}</td>
                            <td>{{ $rating->status }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#editRatingModal{{ $rating->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('user_ratings.destroy', $rating->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                <form action="{{ route('dashboard.user_ratings.acceptRating', $rating->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Rating Modal -->
                        <div class="modal fade" id="editRatingModal{{ $rating->id }}" tabindex="-1"
                            aria-labelledby="editRatingModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editRatingModalLabel">Edit Rating</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('user_ratings.update', $rating->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="user_id" class="form-label">User</label>
                                                <select class="form-control" id="user_id" name="user_id" required>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $rating->user_id == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="factor_id" class="form-label">Factor</label>
                                                <select class="form-control" id="factor_id" name="factor_id" required>
                                                    @foreach ($factors as $factor)
                                                        <option value="{{ $factor->id }}"
                                                            {{ $rating->factor_id == $factor->id ? 'selected' : '' }}>
                                                            {{ $factor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="rating" class="form-label">Rating</label>
                                                <input type="number" class="form-control" id="rating" name="rating"
                                                    value="{{ $rating->rating }}" min="1" max="5" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="comment" class="form-label">Comment</label>
                                                <textarea class="form-control" id="comment" name="comment">{{ $rating->comment }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="active"
                                                        {{ $rating->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive"
                                                        {{ $rating->status == 'inactive' ? 'selected' : '' }}>Inactive
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
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
                {{ $ratings->links() }}
            </div>
        </div>
    </div>

    <!-- Add Rating Modal -->
    <div class="modal fade" id="addRatingModal" tabindex="-1" aria-labelledby="addRatingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRatingModalLabel">Add Rating</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user_ratings.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="factor_id" class="form-label">Factor</label>
                            <select class="form-control" id="factor_id" name="factor_id" required>
                                @foreach ($factors as $factor)
                                    <option value="{{ $factor->id }}">{{ $factor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="1"
                                max="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea class="form-control" id="comment" name="comment"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

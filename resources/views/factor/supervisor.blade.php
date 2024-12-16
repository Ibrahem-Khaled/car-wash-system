<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('orders.title') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('assets/img/logo-ct.png') }}">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f9f9f9;
            direction: rtl;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #4a2f85;
            text-align: center;
            margin-bottom: 30px;
        }

        .order-card {
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .order-status {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #4a2f85;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ed0f7d;
        }

        .input-group {
            max-width: 300px;
            margin: auto;
        }
    </style>
</head>

<body>

    @include('homeLayouts.nav-bar')
    @include('homeLayouts.float-buttons')

    <section class="py-5">
        <div class="container">
            <h2 class="section-title">{{ __('orders.title') }}</h2>

            <div class="row">
                @foreach ($orders as $item)
                    <div class="col-md-6">
                        <div class="order-card bg-white">
                            <h5>{{ __('orders.order_number') }} #{{ $item->id }}</h5>
                            <p><strong>{{ __('orders.product') }}:</strong> {{ $item->product->name }}</p>
                            <p><strong>{{ __('orders.price') }}:</strong> {{ $item->price }} ريال</p>
                            <p><strong>{{ __('orders.car_type') }}:</strong> {{ $item->car_type }}</p>
                            <p><strong>{{ __('orders.car_model') }}:</strong> {{ $item->car_model }}</p>
                            <p><strong>{{ __('orders.car_color') }}:</strong> {{ $item->car_color }}</p>
                            <p><strong>{{ __('orders.car_number') }}:</strong> {{ $item->car_number }}</p>
                            <p><strong>{{ __('orders.car_wash_date') }}:</strong> {{ $item->car_wash }}</p>
                            <p><strong>{{ __('orders.coordinates') }}:</strong> {{ $item->latitude }},
                                {{ $item->longitude }}</p>

                            <p class="order-status">{{ __('orders.status') }}:
                                <span
                                    class="badge 
                                    @if ($item->status == 'declined') bg-danger 
                                    @elseif ($item->status == 'completed') bg-success 
                                    @else bg-warning @endif">
                                    {{ $item->status }}
                                </span>
                            </p>

                            @if ($item->status == 'declined' && $item->decline_reason)
                                <p><strong>{{ __('orders.decline_reason') }}:</strong> {{ $item->decline_reason }}</p>
                            @endif

                            <form action="{{ route('updateOrderStatus', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <p>{{ __('orders.change_status') }}:</p>

                                    @if ($item->status == 'unpaid')
                                        <button class="btn btn-success" name="status" value="acepted"
                                            type="submit">{{ __('orders.accept_order') }}</button>
                                    @elseif ($item->status == 'acepted')
                                        <button class="btn btn-warning" name="status" value="pending"
                                            type="submit">{{ __('orders.in_progress') }}</button>
                                    @elseif ($item->status == 'pending')
                                        <button class="btn btn-success" name="status" value="completed"
                                            type="submit">{{ __('orders.complete') }}</button>
                                    @endif

                                    <button class="btn btn-danger" type="button"
                                        id="declineButton">{{ __('orders.decline_order') }}</button>
                                </div>

                                <div class="mb-3" id="reasonContainer" style="display: none;">
                                    <label for="decline_reason"
                                        class="form-label">{{ __('orders.decline_reason') }}</label>
                                    <textarea class="form-control" name="decline_reason" id="decline_reason" rows="3"></textarea>
                                    <button class="btn btn-danger mt-2" name="status" value="declined"
                                        type="submit">{{ __('orders.confirm_decline') }}</button>
                                </div>
                            </form>

                            @if (Auth::check() && !in_array(auth()->user()->role, ['factor', 'company', 'customer']))
                                <div class="mb-3">
                                    <label for="worker_id" class="form-label">{{ __('orders.assign_worker') }}</label>
                                    <select class="form-select" name="worker_id" id="worker_id">
                                        <option value="">{{ __('orders.select_worker') }}</option>
                                        @foreach ($workers as $worker)
                                            <option value="{{ $worker->id }}"
                                                {{ $item->worker_id == $worker->id ? 'selected' : '' }}>
                                                {{ $worker->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <button class="btn btn-secondary mt-3"
                                onclick="openMap({{ $item->latitude }}, {{ $item->longitude }})">
                                {{ __('orders.view_map') }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('homeLayouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function openMap(lat, lng) {
            if (lat && lng) {
                const googleMapUrl = `https://www.google.com/maps?q=${lat},${lng}`;
                window.open(googleMapUrl, '_blank');
            } else {
                alert('{{ __('orders.no_coordinates') }}');
            }
        }
    </script>
</body>

</html>

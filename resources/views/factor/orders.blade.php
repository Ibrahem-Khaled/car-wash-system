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

        .btn-primary {
            background-color: #4a2f85;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ed0f7d;
        }
    </style>
</head>

<body>

    @include('homeLayouts.nav-bar')
    @include('homeLayouts.float-buttons')

    <section class="py-5">
        <div class="container">
            <h2 class="section-title">{{ __('orders.title') }}</h2>

            <ul class="nav nav-tabs mb-4" id="orderTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="current-orders-tab" data-toggle="tab"
                        data-target="#current-orders" type="button" role="tab" aria-controls="current-orders"
                        aria-selected="true">{{ __('orders.tabs.current_orders') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="past-orders-tab" data-toggle="tab" data-target="#past-orders"
                        type="button" role="tab" aria-controls="past-orders"
                        aria-selected="false">{{ __('orders.tabs.past_orders') }}</button>
                </li>
                @if (auth()->user()->role == 'supervisor')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="accepted-orders-tab" data-toggle="tab"
                            data-target="#accepted-orders" type="button" role="tab"
                            aria-controls="accepted-orders"
                            aria-selected="false">{{ __('orders.tabs.accepted_orders') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="declined-orders-tab" data-toggle="tab"
                            data-target="#declined-orders" type="button" role="tab"
                            aria-controls="declined-orders"
                            aria-selected="false">{{ __('orders.tabs.declined_orders') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="completed-orders-tab" data-toggle="tab"
                            data-target="#completed-orders" type="button" role="tab"
                            aria-controls="completed-orders"
                            aria-selected="false">{{ __('orders.tabs.completed_orders') }}</button>
                    </li>
                @endif
            </ul>

            <div class="tab-content" id="orderTabsContent">
                <div class="tab-pane fade show active" id="current-orders" role="tabpanel"
                    aria-labelledby="current-orders-tab">
                    <div class="row">
                        @foreach ($orders->whereIn('status', ['pending', 'acepted']) as $item)
                            @include('homeLayouts.order-card', ['item' => $item])
                        @endforeach
                    </div>
                </div>

                <div class="tab-pane fade" id="past-orders" role="tabpanel" aria-labelledby="past-orders-tab">
                    <div class="row">
                        @foreach ($orders->whereIn('status', ['completed', 'declined']) as $item)
                            @include('homeLayouts.order-card', ['item' => $item])
                        @endforeach
                    </div>
                </div>

                @if (auth()->user()->role == 'supervisor')
                    <div class="tab-pane fade" id="accepted-orders" role="tabpanel"
                        aria-labelledby="accepted-orders-tab">
                        <div class="row">
                            @foreach ($allOrdersToSupervisor->where('status', 'pending') as $item)
                                @include('homeLayouts.order-card', ['item' => $item])
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="declined-orders" role="tabpanel"
                        aria-labelledby="declined-orders-tab">
                        <div class="row">
                            @foreach ($allOrdersToSupervisor->where('status', 'declined') as $item)
                                @include('homeLayouts.order-card', ['item' => $item])
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="completed-orders" role="tabpanel"
                        aria-labelledby="completed-orders-tab">
                        <div class="row">
                            @foreach ($allOrdersToSupervisor->where('status', 'completed') as $item)
                                @include('homeLayouts.order-card', ['item' => $item])
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @include('homeLayouts.footer')

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

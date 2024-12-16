<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('privacy.title') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="icon" href="{{ asset('assets/img/logo-ct.png') }}">

    <style>
        body {
            font-family: "Cairo", sans-serif;
            direction: rtl;
            text-align: center;
            background-color: #f8f9fa;
        }

        .text-brown {
            color: #4a2f85;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .content-box {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .icon {
            color: #ed0f7d;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    @include('homeLayouts.nav-bar')
    <div class="container py-5">
        <h1 class="text-center text-brown mb-5">{{ __('privacy.title') }}</h1>

        <!-- سياسة الخصوصية -->
        <div class="content-box">
            <h2 class="section-title text-brown">
                <i class="fas fa-user-shield icon"></i>
                {{ __('privacy.privacy.title') }}
            </h2>
            <p>{{ __('privacy.privacy.description') }}</p>
            <h3 class="text-brown">{{ __('privacy.privacy.data_collected') }}</h3>
            <ul>
                @foreach (__('privacy.privacy.data_list') as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
            <h3 class="text-brown">{{ __('privacy.privacy.protection') }}</h3>
            <ul>
                @foreach (__('privacy.privacy.protection_list') as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <!-- سياسة الأحكام والشروط -->
        <div class="content-box">
            <h2 class="section-title text-brown">
                <i class="fas fa-file-contract icon"></i>
                {{ __('privacy.terms.title') }}
            </h2>
            <ul>
                @foreach (__('privacy.terms.terms_list') as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
            <h3 class="text-brown">{{ __('privacy.terms.payment') }}</h3>
            <ul>
                @foreach (__('privacy.terms.payment_list') as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
            <h3 class="text-brown">{{ __('privacy.terms.cancellation') }}</h3>
            <ul>
                @foreach (__('privacy.terms.cancellation_list') as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <!-- سياسة الاسترجاع -->
        <div class="content-box">
            <h2 class="section-title text-brown">
                <i class="fas fa-undo icon"></i>
                {{ __('privacy.refund.title') }}
            </h2>
            <h3 class="text-brown">{{ __('privacy.refund.problem') }}</h3>
            <ul>
                @foreach (__('privacy.refund.problem_list') as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
            <h3 class="text-brown">{{ __('privacy.refund.how_to_refund') }}</h3>
            <ul>
                @foreach (__('privacy.refund.how_to_refund_list') as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <!-- سياسة الإلغاء والتعديل -->
        <div class="content-box">
            <h2 class="section-title text-brown">
                <i class="fas fa-edit icon"></i>
                {{ __('privacy.modification.title') }}
            </h2>
            <ul>
                @foreach (__('privacy.modification.modification_list') as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    @include('homeLayouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

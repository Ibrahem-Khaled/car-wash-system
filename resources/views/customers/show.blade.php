<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف العميل - {{ $user->name }}</title>

    <!-- Import Cairo Font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">

    <!-- Icons Library (Font Awesome) for better visuals -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-purple: #6f42c1;
            --primary-purple-dark: #5a349b;
            --light-bg: #f8f9fa;
            --white-bg: #ffffff;
            --dark-text: #343a40;
            --light-text: #6c757d;
            --border-color: #dee2e6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            --success-bg: #d1e7dd;
            --success-text: #0f5132;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--light-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .main-container {
            display: flex;
            gap: 30px;
            width: 100%;
            max-width: 900px;
            align-items: flex-start;
        }

        .customer-card, .qr-card {
            background-color: var(--white-bg);
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 30px;
            transition: transform 0.3s ease;
        }

        .customer-card {
            flex-basis: 60%;
        }

        .qr-card {
            flex-basis: 40%;
            text-align: center;
        }

        .customer-card:hover, .qr-card:hover {
            transform: translateY(-5px);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }

        .profile-icon {
            font-size: 3rem;
            color: var(--primary-purple);
        }

        .profile-header h2 {
            margin: 0;
            font-size: 1.8rem;
            color: var(--dark-text);
        }
        .profile-header p {
            margin: 0;
            color: var(--light-text);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .stat-item {
            background-color: var(--light-bg);
            padding: 15px;
            border-radius: 12px;
            text-align: center;
        }

        .stat-item .icon {
            font-size: 2rem;
            color: var(--primary-purple);
            margin-bottom: 10px;
        }

        .stat-item h4 {
            margin: 0 0 5px 0;
            font-size: 1.5rem;
            color: var(--dark-text);
        }

        .stat-item p {
            margin: 0;
            font-size: 0.9rem;
            color: var(--light-text);
        }

        .qr-card h3 {
            font-size: 1.5rem;
            color: var(--primary-purple);
            margin-bottom: 15px;
        }

        .qr-code-wrapper {
            padding: 15px;
            background: var(--white-bg);
            border-radius: 15px;
            border: 1px solid var(--border-color);
            display: inline-block;
        }

        .alert-success {
            padding: 15px;
            background-color: var(--success-bg);
            color: var(--success-text);
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }
        }

    </style>
</head>
<body>

    <div class="main-container">

        <!-- Customer Details Card -->
        <div class="customer-card">
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="profile-header">
                <i class="fas fa-user-circle profile-icon"></i>
                <div>
                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->phone_number }}</p>
                </div>
            </div>

            <h4>إحصائيات الولاء</h4>
            <div class="stats-grid">
                <div class="stat-item">
                    <i class="fas fa-star icon"></i>
                    <h4>{{ $totalServices }}</h4>
                    <p>إجمالي الخدمات</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-gift icon"></i>
                    <h4>{{ $totalGifts }}</h4>
                    <p>إجمالي الهدايا</p>
                </div>
                <div class="stat-item">
                    <i class="fas fa-hourglass-half icon"></i>
                    <h4>{{ $remainingForGift }}</h4>
                    <p>خدمات متبقية للهدية</p>
                </div>
            </div>
        </div>

        <!-- QR Code Card -->
        <div class="qr-card">
            <h3>امسح الرمز لإضافة خدمة</h3>
            <div class="qr-code-wrapper">
                {!! QrCode::size(200)->generate($qrCodeUrl) !!}
            </div>
            <p style="color: var(--light-text); margin-top: 15px;">اطلب من العميل الاحتفاظ بهذا الرمز.</p>
        </div>

    </div>

</body>
</html>

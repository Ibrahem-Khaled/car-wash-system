<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف العميل - {{ $user->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        :root {
            --primary-color: #7E57C2;
            --primary-light: #B39DDB;
            --primary-dark: #5E35B1;
            --secondary-color: #d400ff;
            --success-color: #66BB6A;
            --error-color: #EF5350;
            --dark-text: #263238;
            --light-text: #546E7A;
            --light-bg: #F5F5F5;
            --white-bg: #FFFFFF;
            --border-color: #E0E0E0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
            --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: radial-gradient(circle at 10% 20%, rgba(179, 157, 219, 0.1) 0%, rgba(255, 255, 255, 1) 90%);
        }

        .main-container {
            width: 100%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            perspective: 1000px;
        }

        .customer-card,
        .qr-card {
            background: var(--white-bg);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 30px;
            transition: all 0.3s ease;
            transform-style: preserve-3d;
            position: relative;
            overflow: hidden;
        }

        .customer-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 8px;
            background: var(--gradient-primary);
        }

        .qr-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-top: 8px solid var(--secondary-color);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .profile-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            box-shadow: var(--shadow-md);
        }

        .profile-header h2 {
            margin: 0;
            font-size: 1.8rem;
            color: var(--dark-text);
            font-weight: 700;
        }

        .profile-header p {
            margin: 5px 0 0;
            color: var(--light-text);
            font-size: 1rem;
        }

        .stats-section h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: var(--primary-dark);
            position: relative;
            display: inline-block;
            padding-bottom: 5px;
        }

        .stats-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 50%;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 3px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-item {
            background: var(--white-bg);
            border-radius: 12px;
            padding: 20px 15px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .stat-item .icon {
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .stat-item h4 {
            margin: 0 0 5px 0;
            font-size: 1.8rem;
            color: var(--dark-text);
            font-weight: 700;
        }

        .stat-item p {
            margin: 0;
            font-size: 0.9rem;
            color: var(--light-text);
        }

        .stat-item.available-gifts {
            border-top: 3px solid var(--secondary-color);
        }

        .stat-item.available-gifts .icon {
            color: var(--secondary-color);
        }

        .qr-card h3 {
            font-size: 1.5rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
            font-weight: 700;
        }

        .qr-code-wrapper {
            padding: 20px;
            background: var(--white-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            margin-bottom: 20px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
            position: relative;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background-color: rgba(102, 187, 106, 0.15);
            color: #2E7D32;
            border-right: 5px solid var(--success-color);
        }

        .alert-error {
            background-color: rgba(239, 83, 80, 0.15);
            color: #C62828;
            border-right: 5px solid var(--error-color);
        }

        .gift-action-section {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px dashed var(--border-color);
            text-align: center;
        }

        .gift-action-section p {
            font-size: 1.2rem;
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .use-gift-btn {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 12px 30px;
            font-family: 'Tajawal', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(204, 0, 255, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .use-gift-btn:hover {
            background: #cc00ff;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(204, 0, 255, 0.4);
        }

        /* [إضافة هنا] قسم أزرار Wallet */
        .wallet-section {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px dashed var(--border-color);
        }

        .wallet-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        .wallet-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            width: 80%;
            max-width: 280px;
            height: 50px;
            border-radius: 25px;
            font-weight: 700;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            font-family: 'Tajawal', sans-serif;
        }

        .wallet-button:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: var(--shadow-lg);
        }

        .google-wallet {
            background-color: #1F1F1F;
            color: #FFFFFF;
        }

        .apple-wallet {
            background-color: #000000;
            color: #FFFFFF;
        }

        .wallet-button img,
        .wallet-button svg {
            height: 24px;
            margin-right: 12px;
        }

        @media (max-width: 992px) {
            .main-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="main-container animate__animated animate__fadeIn">
        <div class="customer-card">
            @if (session('success'))
                <div class="alert alert-success animate__animated animate__bounceIn">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-error animate__animated animate__shakeX">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <div class="profile-header">
                <div class="profile-icon"><i class="fas fa-user"></i></div>
                <div>
                    <h2>{{ $user->name }}</h2>
                    <p><i class="fas fa-phone-flip"></i> {{ $user->phone }}</p>
                </div>
            </div>

            <div class="stats-section">
                <h3><i class="fas fa-chart-line"></i> إحصائيات الولاء</h3>
                <div class="stats-grid">
                    <div class="stat-item"><i class="fas fa-star icon"></i>
                        <h4>{{ $loyalty['totalServices'] }}</h4>
                        <p>إجمالي الخدمات</p>
                    </div>
                    <div class="stat-item"><i class="fas fa-gift icon"></i>
                        <h4>{{ $loyalty['totalGifts'] }}</h4>
                        <p>إجمالي الهدايا</p>
                    </div>
                    <div class="stat-item"><i class="fas fa-hourglass-half icon"></i>
                        <h4>{{ $loyalty['remainingForGift'] }}</h4>
                        <p>متبقي للهدية</p>
                    </div>
                    <div class="stat-item available-gifts"><i class="fas fa-award icon"></i>
                        <h4>{{ $loyalty['unusedGiftsCount'] }}</h4>
                        <p>هدايا متاحة</p>
                    </div>
                </div>
            </div>

            @if ($loyalty['unusedGiftsCount'] > 0)
                <div class="gift-action-section animate__animated animate__pulse animate__infinite">
                    <p><i class="fas fa-gift"></i> لدى العميل {{ $loyalty['unusedGiftsCount'] }} خدمة مجانية متاحة
                        للاستخدام!</p>
                    <form action="{{ route('loyalty.useGift', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="use-gift-btn"><i class="fas fa-check-circle"></i> استخدام خدمة
                            مجانية الآن</button>
                    </form>
                </div>
            @endif
        </div>

        <div class="qr-card">
            <h3><i class="fas fa-qrcode"></i> بطاقتك الرقمية</h3>
            <div class="qr-code-wrapper">
                {!! QrCode::size(180)->generate($qrCodeUrl) !!}
            </div>

            <div class="wallet-section">
                <p style="color: var(--light-text); font-size: 0.9rem; margin-bottom: 20px;">أضف بطاقتك إلى محفظة هاتفك
                    للوصول السريع!</p>
                <div class="wallet-buttons">
                    @if (!empty($googlePassData['success']))
                        <a href="https://pay.google.com/gp/v/c/{{ $googlePassData['signedJwt'] }}" target="_blank"
                            class="wallet-button google-wallet">
                            <img src="https://cdn-icons-png.flaticon.com/128/196/196556.png"
                                alt="Google Wallet">
                            Google Wallet
                        </a>
                    @endif
                    @if (!empty($applePassData['success']))
                        <a href="{{ $applePassData['downloadUrl'] }}" class="wallet-button apple-wallet">
                            <img src="https://cdn-icons-png.flaticon.com/128/5968/5968279.png"
                                alt="Apple Wallet">
                            Apple Wallet
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.customer-card, .qr-card');
            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const halfWidth = card.offsetWidth / 2;
                    const halfHeight = card.offsetHeight / 2;
                    const rotateX = (y - halfHeight) / 10;
                    const rotateY = (x - halfWidth) / -10;
                    card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'rotateX(0deg) rotateY(0deg)';
                });
            });
        });
    </script>
</body>

</html>

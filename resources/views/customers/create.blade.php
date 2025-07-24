<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء بطاقة ولاء جديدة</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary-purple: #6f42c1;
            --primary-purple-dark: #5a349b;
            --light-bg: #f8f9fa;
            --white-bg: #ffffff;
            --dark-text: #343a40;
            --border-color: #dee2e6;
            --error-bg: #f8d7da;
            --error-text: #842029;
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(to top, #f2f2f7, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            color: var(--dark-text);
        }

        .form-container {
            background-color: var(--white-bg);
            padding: 40px;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 450px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
        }

        /* [إضافة جديدة] قسم الشعار */
        .logo-section {
            margin-bottom: 20px;
        }

        .logo-icon {
            font-size: 4.5rem;
            color: var(--primary-purple);
            line-height: 1;
            margin-bottom: 10px;
        }

        .business-name {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--dark-text);
            letter-spacing: -1px;
        }

        .tagline {
            color: #6c757d;
            margin-top: -5px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: right;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            font-family: 'Cairo', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input[type="text"]:focus {
            outline: none;
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.2);
        }

        /* [إضافة جديدة] تصميم حقل اختيار الجنس */
        .gender-selector {
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }

        .gender-selector input[type="radio"] {
            display: none;
        }

        .gender-selector label {
            flex: 1;
            padding: 12px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 700;
        }

        .gender-selector label i {
            margin-left: 8px;
        }

        .gender-selector input[type="radio"]:checked+label {
            background-color: var(--primary-purple);
            color: white;
            border-color: var(--primary-purple-dark);
            box-shadow: 0 4px 10px rgba(111, 66, 193, 0.3);
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: var(--primary-purple);
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Cairo', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 25px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .submit-btn:hover {
            background: var(--primary-purple-dark);
            transform: translateY(-3px);
        }

        .alert-danger {
            padding: 15px;
            background-color: var(--error-bg);
            color: var(--error-text);
            border: 1px solid #f5c2c7;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: right;
        }

        .alert-danger ul {
            margin: 0;
            padding-right: 20px;
            list-style: none;
        }
    </style>
</head>

<body>
    <div class="form-container animate__animated animate__fadeInUp">

        <div class="logo-section">
            <div class="logo-icon"><img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="img-fluid w-50 h-50"  alt="Logo"></div>
            <h1 class="business-name">المركبة المخملية</h1>
            <p class="tagline">خطوة واحدة تفصلك عن الهدايا والمكافآت!</p>
        </div>

        @include('components.alerts')

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">اسمك الكامل</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    placeholder="مثال: محمد أحمد" required>
            </div>

            <div class="form-group">
                <label for="phone">رقم هاتفك</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                    placeholder="سيتم استخدامه لربط نقاطك" required>
            </div>

            <div class="form-group">
                <label>الجنس</label>
                <div class="gender-selector">
                    <input type="radio" id="male" name="gender" value="male"
                        {{ old('gender') == 'male' ? 'checked' : '' }}>
                    <label for="male"><i class="fa-solid fa-person"></i> ذكر</label>

                    <input type="radio" id="female" name="gender" value="female"
                        {{ old('gender') == 'female' ? 'checked' : '' }}>
                    <label for="female"><i class="fa-solid fa-person-dress"></i> أنثى</label>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-award"></i> أنشئ بطاقتي الآن
            </button>
        </form>
    </div>
</body>

</html>

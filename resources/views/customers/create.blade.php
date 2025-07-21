<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة عميل جديد</title>

    <!-- Import Cairo Font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">

    <style>
        /* CSS Variables for easy theme management */
        :root {
            --primary-purple: #6f42c1;
            /* لون بنفسجي عصري */
            --primary-purple-dark: #5a349b;
            --light-gray: #f8f9fa;
            --dark-text: #343a40;
            --border-color: #dee2e6;
            --error-bg: #f8d7da;
            --error-text: #721c24;
            --error-border: #f5c6cb;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* General Body Styles */
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(to top, #f2f2f7, #ffffff);
            /* خلفية بيضاء مع تدرج خفيف */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: var(--dark-text);
        }

        /* Main Form Container */
        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 450px;
            box-sizing: border-box;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
        }

        /* Form Title */
        .form-container h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-purple);
            margin-bottom: 25px;
        }

        /* Form Group for inputs and labels */
        .form-group {
            margin-bottom: 20px;
            text-align: right;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--dark-text);
        }

        /* Input Fields Styling */
        .form-group input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            font-family: 'Cairo', sans-serif;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
            /* Ensures padding doesn't affect width */
        }

        .form-group input[type="text"]:focus {
            outline: none;
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.2);
        }

        /* Submit Button Styling */
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
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: var(--primary-purple-dark);
            transform: translateY(-2px);
        }

        /* Error Alert Styling */
        .alert-danger {
            padding: 15px;
            background-color: var(--error-bg);
            color: var(--error-text);
            border: 1px solid var(--error-border);
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: right;
        }

        .alert-danger ul {
            margin: 0;
            padding-right: 20px;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>📝 إضافة عميل جديد</h2>

        {{-- Blade syntax to display validation errors --}}
       @include('components.alerts')

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">اسم العميل</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    placeholder="مثال: محمد أحمد" required>
            </div>

            <div class="form-group">
                <label for="phone_number">رقم الهاتف</label>
                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                    placeholder="مثال: 01012345678" required>
            </div>

            <button type="submit" class="submit-btn">إضافة العميل</button>
        </form>
    </div>

</body>

</html>

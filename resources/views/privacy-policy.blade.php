<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سياسة الخصوصية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            direction: rtl;
            text-align: right;
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
        <h1 class="text-center text-brown mb-5">سياسة الخصوصية</h1>

        <!-- سياسة الخصوصية -->
        <div class="content-box">
            <h2 class="section-title text-brown">
                <i class="fas fa-user-shield icon"></i>
                خصوصيتك تهمنا
            </h2>
            <p>نحن ملتزمون بحماية معلوماتك الشخصية. يتم جمع واستخدام بياناتك لتقديم خدمات أفضل، مثل تحديد موقعك للخدمات
                المتنقلة. لن نشارك معلوماتك مع أطراف ثالثة دون إذنك، باستثناء الحالات الضرورية لتحسين الخدمة.</p>
            <h3 class="text-brown">المعلومات التي نجمعها:</h3>
            <ul>
                <li>الاسم، رقم الهاتف، الموقع.</li>
                <li>تفاصيل السيارة.</li>
            </ul>
            <h3 class="text-brown">كيف نحمي بياناتك:</h3>
            <ul>
                <li>تخزين آمن للمعلومات باستخدام تقنيات التشفير.</li>
                <li>تحديد الوصول إلى المعلومات للموظفين المعنيين فقط.</li>
            </ul>
        </div>

        <!-- سياسة الأحكام والشروط -->
        <div class="content-box">
            <h2 class="section-title text-brown">
                <i class="fas fa-file-contract icon"></i>
                سياسة الأحكام والشروط
            </h2>
            <ul>
                <li>استخدام الموقع أو التطبيق يعني موافقتك على هذه الشروط.</li>
                <li>الخدمة متاحة ضمن النطاق الجغرافي المحدد.</li>
                <li>الحجز يعتمد على المواعيد المتاحة.</li>
            </ul>
            <h3 class="text-brown">الدفع:</h3>
            <ul>
                <li>يتم الدفع مقدمًا عند الحجز.</li>
                <li>تشمل الأسعار المعلنة ضريبة القيمة المضافة.</li>
            </ul>
            <h3 class="text-brown">إلغاء الخدمة:</h3>
            <ul>
                <li>يمكن الإلغاء قبل موعد الخدمة بـ 6 ساعات.</li>
                <li>في حالة التأخر عن الموعد المحدد، يحُتسب كموعد منفذ.</li>
            </ul>
        </div>

        <!-- سياسة الاسترجاع -->
        <div class="content-box">
            <h2 class="section-title text-brown">
                <i class="fas fa-undo icon"></i>
                سياسة الاسترجاع
            </h2>
            <h3 class="text-brown">في حالة وجود مشكلة في الخدمة:</h3>
            <ul>
                <li>يمكن تقديم طلب استرجاع خلال 24 ساعة من تنفيذ الخدمة.</li>
                <li>يشمل الاسترجاع الحالات التي يتم فيها تقديم خدمة غير مرضية أو عدم تنفيذ الخدمة وفقًا للوصف.</li>
            </ul>
            <h3 class="text-brown">كيف يتم الاسترجاع؟</h3>
            <ul>
                <li>تقديم طلب عبر البريد الإلكتروني أو رقم خدمة العملاء.</li>
                <li>يتم معالجة الطلب خلال 5 أيام عمل، واسترجاع المبلغ إلى الحساب البنكي.</li>
            </ul>
        </div>

        <!-- سياسة الإلغاء والتعديل -->
        <div class="content-box">
            <h2 class="section-title text-brown">
                <i class="fas fa-edit icon"></i>
                سياسة الإلغاء والتعديل
            </h2>
            <ul>
                <li>يمكن تعديل أو إلغاء موعد الحجز قبل 6 ساعات من الموعد المحدد.</li>
                <li>في حال الإلغاء بعد هذا الوقت، لن يتم استرداد المبلغ.</li>
                <li>تعديل المواعيد متاح بناءً على الجدولة المتوفرة.</li>
            </ul>
        </div>
    </div>

    @include('homeLayouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

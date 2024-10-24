<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المركبة المخملية</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .floating-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 999;
        }

        .floating-buttons a {
            display: block;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s;
        }

        .floating-buttons a img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .floating-buttons a:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>

    <!-- الأزرار العائمة مع صور واتساب وسناب -->
    <div class="floating-buttons">
        <a href="https://wa.me/message/PZZU6X5DK243B1" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="واتساب">
        </a>
        <a href="https://snapchat.com/t/qSwR45Tp" target="_blank">
            <img src="https://1000logos.net/wp-content/uploads/2017/08/Snapchat-logo-768x432.png" alt="سناب شات">
        </a>
    </div>

</body>

</html>

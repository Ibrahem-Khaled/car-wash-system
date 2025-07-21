<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منح خدمة مجانية</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .reward-container { max-width: 500px; margin: auto; padding: 20px; border: 1px solid #198754; background-color: #f0fff8; border-radius: 8px; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"] { width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; }
        button { padding: 10px 20px; background-color: #198754; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .alert-success { padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="reward-container">

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2>🎁 منح خدمة مجانية</h2>
        <p>العميل <strong>{{ $user->name }}</strong> أكمل {{ \App\Http\Controllers\LoyaltyController::SERVICES_TARGET }} خدمات ويستحق خدمة مجانية.</p>
        <hr>

        <form action="{{ route('loyalty.reward.redeem', $user->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="gifted_to_phone_number"><strong>أدخل رقم الهاتف الذي سيحصل على الهدية:</strong></label>
                {{-- يتم ملء الحقل تلقائيًا برقم العميل ويمكن تغييره --}}
                <input type="text" id="gifted_to_phone_number" name="gifted_to_phone_number" value="{{ $user->phone_number }}" required>
            </div>

            <button type="submit">تأكيد ومنح الهدية الآن</button>
        </form>

    </div>

</body>
</html>

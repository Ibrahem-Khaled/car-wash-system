<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملفي الشخصي</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(to right, #4a2f85, #ed0f7d);
            color: white;
            margin: 0;
            padding: 0;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .profile-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 5px solid #4a2f85;
            object-fit: cover;
        }

        .profile-details h2 {
            font-size: 1.8rem;
            color: #4a2f85;
            margin-bottom: 10px;
        }

        .profile-details p {
            color: #333;
            font-size: 0.9rem;
            margin: 5px 0;
        }

        .btn-edit {
            background-color: #4a2f85;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-edit:hover {
            background-color: #ed0f7d;
            transform: scale(1.05);
        }

        .modal-content {
            border-radius: 15px;
        }

        .modal-header {
            background-color: #4a2f85;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .form-control {
            border-radius: 10px;
        }
    </style>
</head>

<body>
    @include('homeLayouts.nav-bar')
    <div class="profile-container">
        <img src="{{ $user->image }}" alt="Profile Image" class="profile-img">
        <div class="profile-details">
            <h2>{{ $user->name }}</h2>
            <p><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
            <p><strong>رقم الهاتف:</strong> {{ $user->phone ?? 'غير متوفر' }}</p>
            <p><strong>العنوان:</strong> {{ $user->address ?? 'غير متوفر' }}</p>
            <p><strong>المدينة:</strong> {{ $user->city ?? 'غير متوفر' }}</p>
            <p><strong>نوع الحساب:</strong> {{ ucfirst($user->role) }}</p>
        </div>
        <button class="btn btn-edit mt-3" data-bs-toggle="modal" data-bs-target="#editModal">تعديل البيانات</button>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">تعديل بيانات الملف الشخصي</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark">الاسم</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-dark">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label text-dark">رقم الهاتف</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ $user->phone }}">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label text-dark">العنوان</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $user->address }}">
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label text-dark">المدينة</label>
                            <input type="text" class="form-control" id="city" name="city"
                                value="{{ $user->city }}">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label text-dark">صورة الملف الشخصي</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

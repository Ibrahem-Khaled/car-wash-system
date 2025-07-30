{{--
    This is the fully refactored User Profile page.
    It uses the same header and footer, is styled with Tailwind CSS, and includes an interactive edit modal.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملفي الشخصي - المركبة المخملية</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background-color: #1e1b4b;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #8b5cf6;
            border-radius: 10px;
            border: 2px solid #1e1b4b;
        }
    </style>

    <script>
        // Customizing Tailwind theme to match the main design
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'velvet': '#4a2f85',
                        'velvet-light': '#6d44a6',
                        'velvet-dark': '#3a236a',
                        'brand-pink': '#ed0f7d',
                        'glow': 'rgba(167, 139, 250, 0.5)',
                    },
                    fontFamily: {
                        cairo: ['Cairo', 'sans-serif']
                    },
                    boxShadow: {
                        'glow-violet': '0 0 25px rgba(167, 139, 250, 0.6)'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 font-cairo" x-data="{ editModalOpen: false }">

    @include('web.header')

    <main>
        <!-- Page Header Section -->
        <section class="bg-gradient-to-br from-velvet-dark to-indigo-900 text-white pt-32 pb-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">ملفي الشخصي</h1>
                <p class="text-lg text-gray-300 mt-4 max-w-2xl mx-auto">إدارة معلوماتك الشخصية وتفضيلاتك بكل سهولة
                    وأمان.</p>
            </div>
        </section>

        <!-- Profile Section -->
        <section class="py-24">
            <div class="container mx-auto px-6 max-w-4xl">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 grid md:grid-cols-3 gap-8 items-center">
                    <!-- Profile Image -->
                    <div class="text-center md:col-span-1">
                        <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://placehold.co/150x150/4a2f85/ffffff?text=' . substr($user->name, 0, 1) }}"
                            alt="Profile Image"
                            class="w-40 h-40 rounded-full mx-auto mb-4 border-4 border-velvet-light object-cover">
                        <button @click="editModalOpen = true"
                            class="bg-brand-pink text-white font-bold py-2 px-6 rounded-full hover:bg-velvet transition-colors duration-300">
                            <i class="fas fa-edit mr-2"></i> تعديل البيانات
                        </button>
                    </div>

                    <!-- Profile Details -->
                    <div class="md:col-span-2">
                        <h2 class="text-3xl font-bold text-velvet mb-6 border-b pb-4">{{ $user->name }}</h2>
                        <div class="space-y-4 text-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-velvet-light w-6 text-center ml-4"></i>
                                <span>{{ $user->email }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone text-velvet-light w-6 text-center ml-4"></i>
                                <span>{{ $user->phone ?? 'غير متوفر' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-velvet-light w-6 text-center ml-4"></i>
                                <span>{{ $user->address ?? 'غير متوفر' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-city text-velvet-light w-6 text-center ml-4"></i>
                                <span>{{ $user->city ?? 'غير متوفر' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-user-tag text-velvet-light w-6 text-center ml-4"></i>
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">{{ ucfirst($user->role) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Edit Profile Modal -->
    <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4" style="display: none;">
        <div @click.away="editModalOpen = false"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" x-show="editModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-velvet mb-6">تعديل بيانات الملف الشخصي</h2>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    {{-- @method('PUT') --}}

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">الاسم</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            required
                            class="mt-1 block w-full px-3 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            required
                            class="mt-1 block w-full px-3 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">رقم الهاتف</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                            class="mt-1 block w-full px-3 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">العنوان</label>
                        <input type="text" name="address" id="address"
                            value="{{ old('address', $user->address) }}"
                            class="mt-1 block w-full px-3 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition">
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">المدينة</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $user->city) }}"
                            class="mt-1 block w-full px-3 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition">
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">صورة الملف
                            الشخصي</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-velvet-light/10 file:text-velvet hover:file:bg-velvet-light/20">
                    </div>

                    <div class="flex justify-end space-x-4 space-x-reverse border-t pt-6 mt-6">
                        <button type="button" @click="editModalOpen = false"
                            class="px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">إلغاء</button>
                        <button type="submit"
                            class="px-8 py-2 text-white bg-brand-pink rounded-lg hover:bg-velvet transition-colors">حفظ
                            التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('web.footer')

</body>

</html>

@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto p-4 md:p-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">تخصيص بطاقات الولاء</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">خطأ!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Apple Wallet Card -->
        <div id="apple-section">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">Apple Wallet (نظام الأختام)</h2>
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Preview -->
                <div class="w-full md:w-1/2">
                    <h3 class="text-lg font-medium mb-2 text-gray-600">معاينة مباشرة</h3>

                    {{-- بيانات افتراضية للمعاينة - يجب تمريرها من الـ Controller --}}
                    @php
                        $servicesForGift = 5; // عدد الخدمات المطلوبة للهدية
                        $currentProgress = 2; // عدد الخدمات المكتملة حالياً (مثال)
                        $giftsEarned = 1;     // عدد الهدايا التي تم الحصول عليها (مثال)
                        $servicesRemaining = $servicesForGift - $currentProgress;
                        // صور افتراضية للرموز - يمكنك استبدالها بروابط صورك
                        $activeStampUrl = "https://placehold.co/100x100/7C3AED/FFFFFF?text=✓";
                        $inactiveStampUrl = "https://placehold.co/100x100/E5E7EB/9CA3AF?text=★";
                    @endphp

                    <div id="apple-wallet-preview" class="w-full max-w-sm mx-auto rounded-2xl p-4 shadow-lg transition-all duration-300 flex flex-col" style="background-color: {{ $appleTemplate->background_color }}; min-height: 420px;">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center">
                                @if($companyUser && $companyUser->image)
                                    <img src="{{ asset('storage/' . $companyUser->image) }}" class="rounded-full mr-3 object-cover border-2 border-white/50" style="width: 36px; height: 36px;" alt="Company Logo">
                                @else
                                    <div class="w-9 h-9 bg-white/30 rounded-full mr-3"></div>
                                @endif
                                <span id="apple-logo-text-preview" class="font-bold text-lg" style="color: {{ $appleTemplate->foreground_color }};">{{ $appleTemplate->logo_text }}</span>
                            </div>
                            <span class="font-mono text-sm" style="color: {{ $appleTemplate->foreground_color }};">•••</span>
                        </div>

                        <!-- Main Content (Stamps) -->
                        <div class="flex-grow flex flex-col items-center justify-center text-center my-4">
                            <p class="font-medium mb-4" style="color: {{ $appleTemplate->foreground_color }};">
                                @if($servicesRemaining > 0)
                                    {{ $servicesRemaining }}
                                    {{ $servicesRemaining > 2 ? 'خدمات متبقية' : 'خدمة متبقية' }} للهدية التالية!
                                @else
                                    لقد حصلت على هدية!
                                @endif
                            </p>
                            <div class="flex justify-center items-center gap-3">
                                @for ($i = 1; $i <= $servicesForGift; $i++)
                                    @if ($i <= $currentProgress)
                                        {{-- Active Stamp Image --}}
                                        <img src="https://cdn-icons-png.flaticon.com/128/2052/2052358.png" width="50" class="stamp rounded-full object-cover transition-all duration-300" alt="Active Stamp">
                                    @else
                                        {{-- Inactive Stamp Image --}}
                                        <img src="https://cdn-icons-png.flaticon.com/128/20/20973.png" width="50" class="stamp rounded-full object-cover transition-all duration-300 opacity-60" alt="Inactive Stamp">
                                    @endif
                                @endfor
                            </div>
                        </div>

                        <!-- Footer Section with QR Code -->
                        <div class="flex justify-between items-end mt-2">
                            <div>
                                <p class="text-xs uppercase" style="color: {{ $appleTemplate->label_color }};">الهدايا المكتسبة</p>
                                <p class="font-medium text-lg" style="color: {{ $appleTemplate->foreground_color }};">{{ $giftsEarned }}</p>
                            </div>
                            <div class="p-1 bg-white rounded-md shadow">
                                {!! $qrCodeSvg ?? QrCode::size(60)->generate('placeholder') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form -->
                <div class="w-full md:w-1/2">
                    <form action="{{ route('wallet.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="platform" value="apple">

                        <div class="space-y-4">
                            <div>
                                <label for="apple_pass_type_id" class="block text-sm font-medium text-gray-700">Pass Type ID</label>
                                <input type="text" name="pass_type_id" id="apple_pass_type_id" value="{{ old('pass_type_id', $appleTemplate->pass_type_id) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="apple_logo_text" class="block text-sm font-medium text-gray-700">النص بجانب الشعار</label>
                                <input type="text" name="logo_text" id="apple_logo_text" value="{{ old('logo_text', $appleTemplate->logo_text) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <label for="apple_background_color" class="block text-sm font-medium text-gray-700">لون الخلفية</label>
                                    <input type="color" name="background_color" id="apple_background_color" value="{{ old('background_color', $appleTemplate->background_color) }}" class="mt-1 block w-full h-10 rounded-md border-gray-300">
                                </div>
                                <div class="w-1/2">
                                    <label for="apple_foreground_color" class="block text-sm font-medium text-gray-700">لون النص الأساسي</label>
                                    <input type="color" name="foreground_color" id="apple_foreground_color" value="{{ old('foreground_color', $appleTemplate->foreground_color) }}" class="mt-1 block w-full h-10 rounded-md border-gray-300">
                                </div>
                            </div>
                             <div>
                                <label for="apple_label_color" class="block text-sm font-medium text-gray-700">لون النص الثانوي</label>
                                <input type="color" name="label_color" id="apple_label_color" value="{{ old('label_color', $appleTemplate->label_color) }}" class="mt-1 block w-full h-10 rounded-md border-gray-300">
                            </div>
                            <div class="flex items-center">
                                <input id="apple_is_active" name="is_active" type="checkbox" value="1" {{ $appleTemplate->is_active ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="apple_is_active" class="ml-2 block text-sm text-gray-900">تفعيل القالب</label>
                            </div>
                            <div>
                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    حفظ قالب آبل
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <hr class="lg:hidden my-8">

        <!-- Google Wallet Card -->
        <div id="google-section">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">Google Wallet</h2>
             <div class="flex flex-col md:flex-row gap-6">
                <!-- Preview -->
                <div class="w-full md:w-1/2">
                    <h3 class="text-lg font-medium mb-2 text-gray-600">معاينة مباشرة</h3>
                     <div id="google-wallet-preview" class="w-full max-w-sm mx-auto rounded-lg overflow-hidden shadow-lg transition-all duration-300">
                        <div class="p-4" style="background-color: {{ $googleTemplate->background_color }};">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-white/30 rounded-full mr-3"></div>
                                <span id="google-logo-text-preview" class="font-bold text-xl" style="color: {{ $googleTemplate->foreground_color }};">{{ $googleTemplate->logo_text }}</span>
                            </div>
                        </div>
                        <div class="bg-white p-4">
                             <p id="google-label-preview" class="text-xs uppercase" style="color: {{ $googleTemplate->label_color }};">اسم العضو</p>
                             <p id="google-main-text-preview" class="text-lg font-medium text-gray-800">محمد الأحمدي</p>
                             <div class="w-full h-20 my-4 bg-gray-200 flex items-center justify-center">
                                <p class="text-gray-500 text-sm">Barcode/QR Placeholder</p>
                             </div>
                        </div>
                    </div>
                </div>
                <!-- Form -->
                <div class="w-full md:w-1/2">
                    <form action="{{ route('wallet.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="platform" value="google">

                        <div class="space-y-4">
                            <div>
                                <label for="google_pass_type_id" class="block text-sm font-medium text-gray-700">Pass Class ID</label>
                                <input type="text" name="pass_type_id" id="google_pass_type_id" value="{{ old('pass_type_id', $googleTemplate->pass_type_id) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="google_logo_text" class="block text-sm font-medium text-gray-700">النص بجانب الشعار</label>
                                <input type="text" name="logo_text" id="google_logo_text" value="{{ old('logo_text', $googleTemplate->logo_text) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <label for="google_background_color" class="block text-sm font-medium text-gray-700">لون الترويسة</label>
                                    <input type="color" name="background_color" id="google_background_color" value="{{ old('background_color', $googleTemplate->background_color) }}" class="mt-1 block w-full h-10 rounded-md border-gray-300">
                                </div>
                                <div class="w-1/2">
                                    <label for="google_foreground_color" class="block text-sm font-medium text-gray-700">لون نص الترويسة</label>
                                    <input type="color" name="foreground_color" id="google_foreground_color" value="{{ old('foreground_color', $googleTemplate->foreground_color) }}" class="mt-1 block w-full h-10 rounded-md border-gray-300">
                                </div>
                            </div>
                             <div>
                                <label for="google_label_color" class="block text-sm font-medium text-gray-700">لون نص العنوان</label>
                                <input type="color" name="label_color" id="google_label_color" value="{{ old('label_color', $googleTemplate->label_color) }}" class="mt-1 block w-full h-10 rounded-md border-gray-300">
                            </div>
                            <div class="flex items-center">
                                <input id="google_is_active" name="is_active" type="checkbox" value="1" {{ $googleTemplate->is_active ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="google_is_active" class="ml-2 block text-sm text-gray-900">تفعيل القالب</label>
                            </div>
                            <div>
                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    حفظ قالب جوجل
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Apple Wallet Live Preview ---
    const appleForm = document.querySelector('#apple-section form');
    const applePreview = {
        card: document.getElementById('apple-wallet-preview'),
        logoText: document.getElementById('apple-logo-text-preview'),
        primaryTexts: document.querySelectorAll('#apple-wallet-preview .font-medium, #apple-wallet-preview .font-bold, #apple-wallet-preview #apple-logo-text-preview, #apple-wallet-preview .font-mono'),
        secondaryTexts: document.querySelectorAll('#apple-wallet-preview .uppercase'),
    };

    appleForm.addEventListener('input', function(e) {
        const target = e.target;
        const value = target.value;

        switch (target.name) {
            case 'logo_text':
                applePreview.logoText.textContent = value;
                break;
            case 'background_color':
                applePreview.card.style.backgroundColor = value;
                break;
            case 'foreground_color':
                applePreview.primaryTexts.forEach(el => el.style.color = value);
                break;
            case 'label_color':
                applePreview.secondaryTexts.forEach(el => el.style.color = value);
                break;
        }
    });

    // --- Google Wallet Live Preview ---
    const googleForm = document.querySelector('#google-section form');
    const googlePreview = {
        header: document.querySelector('#google-wallet-preview > div:first-child'),
        logoText: document.getElementById('google-logo-text-preview'),
        label: document.getElementById('google-label-preview')
    };

    googleForm.addEventListener('input', function(e) {
        const target = e.target;
        const value = target.value;

        switch (target.name) {
            case 'logo_text':
                googlePreview.logoText.textContent = value;
                break;
            case 'background_color':
                googlePreview.header.style.backgroundColor = value;
                break;
            case 'foreground_color':
                googlePreview.logoText.style.color = value;
                break;
            case 'label_color':
                googlePreview.label.style.color = value;
                break;
        }
    });
});
</script>
@endpush

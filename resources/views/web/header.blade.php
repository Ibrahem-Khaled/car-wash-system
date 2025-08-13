<header x-data="{ mobileMenuOpen: false, userDropdownOpen: false }"
    class="bg-velvet-dark/80 backdrop-blur-lg fixed top-0 left-0 w-full z-50 transition-all duration-300 shadow-2xl">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-20">
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}"
                    class="flex items-center space-x-2 space-x-reverse text-white text-xl sm:text-2xl font-bold tracking-wider">
                    <img src="{{ asset('storage/' . $companyUser->image) }}" alt="Logo" class="h-10 w-10 rounded-full">
                    <span>{{ $companyUser->name }}</span>
                </a>
            </div>

            <nav class="hidden md:flex items-center space-x-6 space-x-reverse">
                <a href="{{ route('home') }}"
                    class="text-gray-300 hover:text-brand-pink transition-colors duration-300">الرئيسية</a>
                <a href="{{ route('about-us') }}"
                    class="text-gray-300 hover:text-brand-pink transition-colors duration-300">من نحن</a>
                <a href="{{ route('services') }}"
                    class="text-gray-300 hover:text-brand-pink transition-colors duration-300">خدماتنا</a>
                <a href="{{ route('subscribtion') }}"
                    class="text-gray-300 hover:text-brand-pink transition-colors duration-300">الاشتراكات</a>
                <a href="{{ route('contact-us') }}"
                    class="text-gray-300 hover:text-brand-pink transition-colors duration-300">تواصل معنا</a>
            </nav>

            <div class="hidden md:flex items-center space-x-4 space-x-reverse">
                <form action="{{ route('change-language') }}" method="POST" id="languageFormDesktop">
                    @csrf
                    <input type="hidden" name="language" value="{{ app()->getLocale() }}">
                    <div class="flex items-center space-x-2 space-x-reverse text-gray-300 text-sm">
                        <span>AR</span>
                        <label for="languageSwitchDesktop" class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="languageSwitchDesktop" class="sr-only peer"
                                {{ app()->getLocale() == 'en' ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-pink">
                            </div>
                        </label>
                        <span>EN</span>
                    </div>
                </form>

                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center">
                            <img src="{{ Auth::user()->image ?? 'https://placehold.co/40x40/f0f0f0/4a2f85?text=U' }}"
                                alt="User Avatar" class="h-10 w-10 rounded-full object-cover border-2 border-violet-400">
                        </button>
                        <div x-show="open" x-transition
                            class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-right z-20">
                            <div class="px-4 py-3 text-sm text-gray-900">
                                <div class="font-medium">{{ Auth::user()->name }}</div>
                            </div>
                            <div class="border-t border-gray-200"></div>
                            <a href="{{ route('profile') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">ملفي الشخصي</a>
                            <a href="{{ route('user.orders') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">طلباتي</a>
                            <a href="{{ route('user.subscriptions') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">اشتراكاتي</a>
                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('home.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">لوحة تحكم المسؤول</a>
                            @endif
                            <a href="{{ route('customers.show') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">نقاط الولاء</a>

                            <div class="border-t border-gray-200"></div>

                            <a href="{{ route('logout') }}"
                                class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                تسجيل الخروج
                            </a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-violet-600 hover:bg-brand-pink text-white font-bold py-2 px-5 rounded-full transition-all duration-300">
                        تسجيل الدخول
                    </a>
                @endauth
            </div>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="md:hidden pb-4" x-transition>
            <nav class="flex flex-col items-center space-y-4 py-4 border-b border-gray-700">
                <a href="{{ route('home') }}"
                    class="text-gray-300 hover:text-brand-pink transition-colors duration-300">الرئيسية</a>
                <a href="{{ route('about-us') }}"
                    class="text-gray-300 hover:text-brand-pink transition-colors duration-300">من نحن</a>
                <a href="{{ route('services') }}"
                    class="text-gray-300 hover:text-brand-pink transition-colors duration-300">خدماتنا</a>
                <a href="{{ route('subscribtion') }}"
                    class="text-gray-300 hover:text-brand-pink transition-colors duration-300">الاشتراكات</a>
                <a href="{{ route('contact-us') }}"
                    class="text-gray-300 hover:text-brand-pink transition-colors duration-300">تواصل معنا</a>
            </nav>

            <div class="flex flex-col items-center space-y-4 pt-4">
                @auth
                    {{-- Collapsible user menu for mobile --}}
                    <div class="w-full text-center" x-data="{ userMenuOpen: false }">

                        <button @click="userMenuOpen = !userMenuOpen" class="flex flex-col items-center w-full focus:outline-none p-2 rounded-lg hover:bg-white/10 transition-colors duration-300">
                            <div class="flex justify-center">
                                <img src="{{ Auth::user()->image ?? 'https://placehold.co/40x40/f0f0f0/4a2f85?text=U' }}"
                                     alt="User Avatar" class="h-12 w-12 rounded-full object-cover border-2 border-violet-400">
                            </div>
                            <div class="font-medium text-white mt-2 flex items-center">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 mr-2 transition-transform duration-300" :class="{ 'rotate-180': userMenuOpen }" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </button>

                        <div x-show="userMenuOpen" x-transition class="w-full mt-3 pt-3 border-t border-gray-700">
                            <div class="flex flex-col space-y-3">
                                <a href="{{ route('profile') }}" class="text-gray-300 hover:text-brand-pink">ملفي الشخصي</a>
                                <a href="{{ route('user.orders') }}" class="text-gray-300 hover:text-brand-pink">طلباتي</a>
                                <a href="{{ route('user.subscriptions') }}" class="text-gray-300 hover:text-brand-pink">اشتراكاتي</a>
                                @if (Auth::user()->isAdmin())
                                    <a href="{{ route('home.dashboard') }}" class="text-gray-300 hover:text-brand-pink">لوحة تحكم المسؤول</a>
                                @endif
                                <a href="{{ route('customers.show') }}" class="text-gray-300 hover:text-brand-pink">نقاط الولاء</a>
                                <div class="border-t border-gray-700 my-1"></div>
                                <a href="{{ route('logout') }}" class="text-gray-300 hover:text-brand-pink">تسجيل الخروج</a>
                            </div>
                        </div>

                    </div>
                @else
                    {{-- Login button for guests on mobile --}}
                    <a href="{{ route('login') }}"
                        class="bg-violet-600 hover:bg-brand-pink text-white font-bold py-2 px-5 rounded-full transition-all duration-300">
                        تسجيل الدخول
                    </a>
                @endauth

                <form action="{{ route('change-language') }}" method="POST" id="languageFormMobile"
                    class="mt-4">
                    @csrf
                    <input type="hidden" name="language" value="{{ app()->getLocale() }}">
                    <div class="flex items-center space-x-2 space-x-reverse text-gray-300 text-sm">
                        <span>AR</span>
                        <label for="languageSwitchMobile" class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="languageSwitchMobile" class="sr-only peer"
                                {{ app()->getLocale() == 'en' ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-pink">
                            </div>
                        </label>
                        <span>EN</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const langSwitchDesktop = document.getElementById('languageSwitchDesktop');
        const langFormDesktop = document.getElementById('languageFormDesktop');

        const langSwitchMobile = document.getElementById('languageSwitchMobile');
        const langFormMobile = document.getElementById('languageFormMobile');

        function handleLanguageChange(checkbox, form) {
            if (checkbox && form) { // Add check for form existence
                checkbox.addEventListener('change', function() {
                    const langInput = form.querySelector('input[name="language"]');
                    langInput.value = this.checked ? 'en' : 'ar';
                    form.submit();
                });
            }
        }

        handleLanguageChange(langSwitchDesktop, langFormDesktop);
        handleLanguageChange(langSwitchMobile, langFormMobile);
    });
</script>

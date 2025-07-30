<!-- START: layouts/footer.blade.php -->
<footer class="bg-velvet pt-20 pb-8 text-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center md:text-right">
            <!-- Quick Links -->
            <div>
                <h5 class="font-bold text-xl mb-5">{{ __('footer.quick_links') }}</h5>
                <a href="{{ route('about-us') }}"
                    class="block mb-3 text-gray-300 hover:text-brand-pink transition-colors">{{ __('footer.about_us') }}</a>
                <a href="{{ route('services') }}"
                    class="block mb-3 text-gray-300 hover:text-brand-pink transition-colors">{{ __('footer.services') }}</a>
                <a href="{{ route('subscribtion') }}"
                    class="block mb-3 text-gray-300 hover:text-brand-pink transition-colors">{{ __('footer.subscriptions') }}</a>
                <a href="{{ route('privacy-policy') }}"
                    class="block mb-3 text-gray-300 hover:text-brand-pink transition-colors">{{ __('footer.privacy_policy') }}</a>
            </div>

            <!-- Contact Info -->
            <div>
                <h5 class="font-bold text-xl mb-5">{{ __('footer.contact_us') }}</h5>
                <div class="text-gray-300 space-y-3">
                    <p class="flex items-center justify-center md:justify-start">
                        <i class="fas fa-phone text-brand-pink ml-3"></i>
                        <span>{{ __('footer.phone') }}: {{ $companyUser?->phone ?? '+966 12 345 6789' }}</span>
                    </p>
                    <p class="flex items-center justify-center md:justify-start">
                        <i class="fas fa-envelope text-brand-pink ml-3"></i>
                        <span>{{ __('footer.email') }}: {{ $companyUser?->email ?? 'info@velvetvehicle.com' }}</span>
                    </p>
                    <p class="flex items-center justify-center md:justify-start">
                        <i class="fas fa-map-marker-alt text-brand-pink ml-3"></i>
                        <span>{{ __('footer.address') }}: {{ $companyUser?->address ?? 'الرياض' }} -
                            {{ $companyUser?->city ?? 'المملكة العربية السعودية' }}</span>
                    </p>
                    <a href="https://wa.me/message/PZZU6X5DK243B1" target="_blank"
                        class="inline-flex items-center justify-center md:justify-start hover:text-brand-pink transition-colors">
                        <i class="fab fa-whatsapp text-brand-pink ml-3"></i>
                        <span>{{ __('footer.contact_now') }}</span>
                    </a>
                </div>
            </div>

            <!-- Social Media -->
            <div class="text-center md:text-right">
                <h5 class="font-bold text-xl mb-5">{{ __('footer.follow_us') }}</h5>
                <div class="flex justify-center md:justify-start space-x-6 space-x-reverse">
                    <a href="https://web.facebook.com/velvet.vehicle" target="_blank"
                        class="text-gray-300 hover:text-brand-pink transition-colors text-3xl"><i
                            class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/velvet_vehicle" target="_blank"
                        class="text-gray-300 hover:text-brand-pink transition-colors text-3xl"><i
                            class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"
                        class="text-gray-300 hover:text-brand-pink transition-colors text-3xl"><i
                            class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank"
                        class="text-gray-300 hover:text-brand-pink transition-colors text-3xl"><i
                            class="fab fa-snapchat"></i></a>
                </div>
            </div>
        </div>

        <div class="text-center text-gray-500 pt-8 mt-10 border-t border-velvet-light/20">
            <p>&copy; {{ date('Y') }} {{ __('footer.all_rights_reserved') }} {{ $companyUser?->name ?? 'Velvet Vehicle' }}.</p>
        </div>
    </div>
</footer>
<!-- END: layouts/footer.blade.php -->

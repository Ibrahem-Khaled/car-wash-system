<style>
    body {
        font-family: "Cairo", sans-serif;
        background-color: #ffffff;
        margin: 0;
        padding: 0;
    }

    /* Footer Styling */
    .footer {
        background-color: #4a2f85;
        color: #fff;
        padding: 60px 0;
    }

    .footer h5 {
        font-weight: 700;
        margin-bottom: 20px;
    }

    .footer a {
        color: #fff;
        text-decoration: none;
        margin-bottom: 10px;
        display: block;
        transition: color 0.3s ease;
    }

    .footer a:hover {
        color: #ed0f7d;
    }

    .footer .social-icons a {
        margin: 0 10px;
        font-size: 24px;
        transition: color 0.3s ease;
    }

    .footer .social-icons a:hover {
        color: #ed0f7d;
    }

    .footer .contact-info p {
        margin-bottom: 8px;
        font-size: 15px;
        margin: 5;
    }

    .footer .contact-info i {
        margin-right: 8px;
        color: #ed0f7d;
    }

    .footer-bottom {
        text-align: center;
        padding: 15px 0;
        background-color: #333;
        color: #fff;
        font-size: 14px;
    }

    /* توزيع متناسق */
    .footer .container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 30px;
    }

    .footer .col {
        flex: 1;
        min-width: 250px;
    }

    .social-icons {
        display: flex;
        justify-content: center;
        margin-top: 15px;
    }

    /* مظهر متجاوب */
    @media (max-width: 768px) {
        .footer .container {
            flex-direction: column;
            text-align: center;
        }

        .footer .social-icons {
            justify-content: center;
        }
    }
</style>


<footer class="footer">
    <div class="container">
        <!-- روابط سريعة -->
        <div class="col">
            <h5>{{ __('footer.quick_links') }}</h5>
            <a href="{{ route('about-us') }}">{{ __('footer.about_us') }}</a>
            <a href="{{ route('services') }}">{{ __('footer.services') }}</a>
            <a href="{{ route('subscribtion') }}">{{ __('footer.subscriptions') }}</a>
            <a href="{{ route('privacy-policy') }}">{{ __('footer.privacy_policy') }}</a>
        </div>

        <!-- وسائل التواصل الاجتماعي -->
        <div class="col text-center">
            <h5>{{ __('footer.follow_us') }}</h5>
            <div class="social-icons">
                <a href="https://web.facebook.com/velvet.vehicle" target="_blank" class="fab fa-facebook"></a>
                <a href="https://www.instagram.com/velvet_vehicle" target="_blank" class="fab fa-instagram"></a>
            </div>
        </div>

        <!-- معلومات الاتصال -->
        <div class="col">
            <h5>{{ __('footer.contact_us') }}</h5>
            <div class="contact-info">
                <p><i class="fas fa-phone"></i>{{ __('footer.phone') }}: {{ $companyUser?->phone }}</p>
                <p><i class="fas fa-envelope"></i>{{ __('footer.email') }}: {{ $companyUser?->email }}</p>
                <p><i class="fas fa-map-marker-alt"></i>{{ __('footer.address') }}: {{ $companyUser?->address }} -
                    {{ $companyUser?->city }}</p>
                <a href="https://wa.me/message/PZZU6X5DK243B1" target="_blank">
                    <i class="fas fa-envelope"></i>{{ __('footer.contact_now') }}
                </a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} {{ __('footer.all_rights_reserved') }} المركبة المخملية.</p>
    </div>
</footer>

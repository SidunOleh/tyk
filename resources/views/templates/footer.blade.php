    <footer class="footer">
        <div class="container">
            <div class="col">
                <a href="{{ route('pages.home') }}" class="logo"><img src="{{ asset('/assets/img/LogoFooter.svg') }}" alt="" /> </a>
                <div class="socials">
                    <p class="title">Соціальні мережі</p>
                    <div class="socials-list">
                        <a href="" class="socials-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                <path
                                    d="M15.6 4H32.4C38.8 4 44 9.2 44 15.6V32.4C44 35.4765 42.7779 38.427 40.6024 40.6024C38.427 42.7779 35.4765 44 32.4 44H15.6C9.2 44 4 38.8 4 32.4V15.6C4 12.5235 5.22214 9.57298 7.39756 7.39756C9.57298 5.22214 12.5235 4 15.6 4ZM15.2 8C13.2904 8 11.4591 8.75857 10.1088 10.1088C8.75857 11.4591 8 13.2904 8 15.2V32.8C8 36.78 11.22 40 15.2 40H32.8C34.7096 40 36.5409 39.2414 37.8912 37.8912C39.2414 36.5409 40 34.7096 40 32.8V15.2C40 11.22 36.78 8 32.8 8H15.2ZM34.5 11C35.163 11 35.7989 11.2634 36.2678 11.7322C36.7366 12.2011 37 12.837 37 13.5C37 14.163 36.7366 14.7989 36.2678 15.2678C35.7989 15.7366 35.163 16 34.5 16C33.837 16 33.2011 15.7366 32.7322 15.2678C32.2634 14.7989 32 14.163 32 13.5C32 12.837 32.2634 12.2011 32.7322 11.7322C33.2011 11.2634 33.837 11 34.5 11ZM24 14C26.6522 14 29.1957 15.0536 31.0711 16.9289C32.9464 18.8043 34 21.3478 34 24C34 26.6522 32.9464 29.1957 31.0711 31.0711C29.1957 32.9464 26.6522 34 24 34C21.3478 34 18.8043 32.9464 16.9289 31.0711C15.0536 29.1957 14 26.6522 14 24C14 21.3478 15.0536 18.8043 16.9289 16.9289C18.8043 15.0536 21.3478 14 24 14ZM24 18C22.4087 18 20.8826 18.6321 19.7574 19.7574C18.6321 20.8826 18 22.4087 18 24C18 25.5913 18.6321 27.1174 19.7574 28.2426C20.8826 29.3679 22.4087 30 24 30C25.5913 30 27.1174 29.3679 28.2426 28.2426C29.3679 27.1174 30 25.5913 30 24C30 22.4087 29.3679 20.8826 28.2426 19.7574C27.1174 18.6321 25.5913 18 24 18Z"
                                    fill="white"
                                />
                            </svg>
                        </a>
                        <a href="" class="socials-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                <path
                                    d="M24 4.08002C13 4.08002 4 13.06 4 24.12C4 34.12 11.32 42.42 20.88 43.92V29.92H15.8V24.12H20.88V19.7C20.88 14.68 23.86 11.92 28.44 11.92C30.62 11.92 32.9 12.3 32.9 12.3V17.24H30.38C27.9 17.24 27.12 18.78 27.12 20.36V24.12H32.68L31.78 29.92H27.12V43.92C31.8329 43.1757 36.1244 40.771 39.2199 37.1401C42.3153 33.5092 44.0107 28.8913 44 24.12C44 13.06 35 4.08002 24 4.08002Z"
                                    fill="white"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <p class="title">Меню</p>
                <ul class="menu-list list">
                    <li class="menu-item"><a href="{{ route('pages.home') }}" class="menu-link">Головна</a></li>
                </ul>
            </div>
            <div class="col">
                <p class="title">Контакти</p>
                <ul class="contact-list list">
                    <li class="contact-item">
                        <span><img src="{{ asset('/assets/img/solar_phone.svg') }}" alt="" />Телефон</span>
                        <a href="tel:" class="contact-link">+380974129090</a>
                    </li>
                    <li class="contact-item">
                        <span><img src="{{ asset('/assets/img/location.svg') }}" alt="" />Адреса</span>
                        <a href="#" class="contact-link">вул. Івана Труша 5А, Золочів</a>
                    </li>
                    <li class="contact-item">
                        <span><img src="{{ asset('/assets/img/mail.svg') }}" alt="" />Email</span>
                        <a href="mailto:info@tyk-tyk.biz" class="contact-link">info@tyk-tyk.biz</a>
                    </li>
                </ul>
            </div>
            <div class="col">
                <a href="#" class="btn">Замовити кур’єра</a>
                <div class="download">
                    <p class="title">Завантажити додаток</p>
                    <div class="download-buttons">
                        <a href="#" class="download-btn"><img src="{{ asset('/assets/img/AppStore.svg') }}" alt="" /></a>
                        <a href="#" class="download-btn"><img src="{{ asset('/assets/img/GooglePlay.svg') }}" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">Copyright tyk-tyk.biz {{ date('Y') }}, All right reserved</div>
        </div>
    </footer>
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('/assets/js/just-validate.production.min.js') }}"></script>
    <script src="{{ asset('/assets/js/fancybox.umd.js') }}"></script>
    <script src="{{ asset('/assets/js/main.js') }}"></script>
</body>

</html>
<section class="callToAction">
    <img src="{{ asset('/assets/img/ctaR.webp') }}" alt="" class="back left" />
    <img src="{{ asset('/assets/img/ctaR.webp') }}" alt="" class="back right" />
    <div class="container">
        <img src="{{ asset('/assets/img/ctaPhones.svg') }}" alt="" class="phones" />
        <div class="card">
            <h2 class="section_title">
                {!! get_content_value('home_app_title') !!}
            </h2>
            <p class="text_18">
                {!! get_content_value('home_app_subtitle') !!}
            </p>
            <div class="downloadBtns">
                <a href="https://apps.apple.com/ua/app/тук-тук-сервіс-твого-міста/id6745031284?l=uk"><img src="{{ asset('/assets/img/AppStoreBL.svg') }}" alt="" /></a>
                <a href="https://play.google.com/store/apps/details?id=com.tyktyk.tyktyk"><img src="{{ asset('/assets/img/googlePlayBl.svg') }}" alt="" /></a>
            </div>
        </div>
    </div>
</section>

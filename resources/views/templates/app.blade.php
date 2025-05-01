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
                <a href="https://apps.apple.com/us/app/%D1%82%D1%83%D0%BA-%D1%82%D1%83%D0%BA/id1548288578#?platform=iphone"><img src="{{ asset('/assets/img/AppStoreBL.svg') }}" alt="" /></a>
                <a href="https://play.google.com/store/apps/details?id=com.tuktuk.tuk_tuk_app"><img src="{{ asset('/assets/img/googlePlayBl.svg') }}" alt="" /></a>
            </div>
        </div>
    </div>
</section>

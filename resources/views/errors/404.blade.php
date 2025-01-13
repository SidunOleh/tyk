@include('templates.header')

<section class="service-section">
    <div class="container">
        <div class="left">
            <h2 class="section_title">
                Сторінку не знайдено
            </h2>
            <p class="title_20">
                Будь ласка, спробуйте ще раз або поверніться на головну сторінку
            </p>
            <a href="{{ route('pages.home') }}" class="btn">
                Повернутися на головну
            </a>
        </div>

        <div class="icon">
            <img src="{{ asset('/assets/img/404.svg') }}" alt="" />
        </div>
    </div>
</section>

@include('templates.footer')
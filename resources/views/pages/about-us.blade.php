@include('templates.header', [
    'title' => get_content_value('about_meta_title', 'Про нас'),
    'description' => get_content_value('about_meta_description'),
])

<section class="page-hero" style="background-image: url('{{ get_content_value('about_first_img') }}')">
    <div class="wrapper">
        <div class="container">
            <h1 class="page-hero_title">
                {!! get_content_value('about_first_title') !!}
            </h1>
        </div>
    </div>
</section>

<section class="aboutUs">
    <div class="container">
        <h2 class="section_title">
            {!! get_content_value('about_info_title') !!}
        </h2>
        <div class="wrapper">
            <div class="aboutCard">
                <img src="{{ asset('/assets/img/delMan.svg') }}" alt="" class="man" />
                <div class="content">
                    {!! get_content_value('about_info_text') !!}
                    <a href="tel:+380974129090" class="btn">
                        Зв’язатися з нами
                    </a>
                </div>
            </div>
            <div class="stat">
                @foreach (get_content_value('about_info_items', []) as $item)
                <div class="stat-item">
                    <img src="{{ $item['icon'] }}" alt="" class="icon" />
                    <p class="num">{!! $item['title'] !!}</p>
                    <p class="title_16">{!! $item['subtitle'] !!}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@if ($items = get_content_value('about_examples_items', []))
<section class="examples">
    <div class="container">
        <h2 class="section_title">
            {!! get_content_value('about_exapmles_title') !!}
        </h2>
        <div class="examples-list">
            @foreach ($items as $item)
            <div class="examples-item">
                <div class="img-card"><img src="{{ $item['img'] }}" alt="" /></div>
                <div class="card">
                    <p class="title_20">
                        {!! $item['service'] !!}
                    </p>
                    <p class="label taxi">
                        {!! $item['type'] !!}
                    </p>
                </div>
                <div class="contentCard">
                    <div class="block">
                        <p class="title_20">
                            {!! $item['title'] !!}
                        </p>
                        <p class="text_14">
                            {!! $item['text'] !!}
                        </p>
                    </div>

                    <div class="block">
                        <p class="title_16">
                            {!! $item['bottom_title'] !!}
                        </p>
                        <p class="text_16">
                            {!! $item['bottom_text'] !!}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <a href="{{ route('pages.order-car', ['service' => 'Кур\'єр']) }}" class="btn">
            Замовити доставку
        </a>
    </div>

</section>
@endif

@include('templates.app')

@include('templates.reviews')

<section class="contactUs">
    <div class="container">
        <div class="wrapper">
            <img src="{{ asset('/assets/img/delMan.svg') }}" alt="" class="man" />
            <img src="{{ asset('/assets/img/redBack.svg') }}" alt="" class="back" />
            <h2 class="section_title">
                Зв’язатись з нами
            </h2>
            <div class="form-wrapper">
                <form class="contactForm" id="main-form">
                    @csrf
                    <div class="input-wrapper input-box">
                        <input type="text" placeholder="Ваше ім’я та прізвище*" name="full_name" id="name" required />
                    </div>
                    <div class="input-wrapper input-box">
                        <input type="tel" name="phone" id="tel" class="phoneInput" required placeholder="Ваш номер телефону*" />
                    </div>
                    <div class="input-wrapper input-box">
                        <input id="email" name="email" class="input" autocomplete="off" type="text" placeholder="Ваш email*" />
                    </div>
                    <div class="input-wrapper input-box">
                        <textarea name="message" type="text" placeholder="Ваше повідомлення"></textarea>
                    </div>
                    <button class="btn white" type="submit">Відправити</button>
                </form>
            </div>
        </div>
    </div>
</section>

@include('templates.footer')
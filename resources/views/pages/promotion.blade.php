@include('templates.header', ['title' => $promotion->title])

<section class="page-hero" style="background-image: url('{{ $promotion->image }}')">
    <div class="wrapper">
        <div class="container">
            <h1 class="page-hero_title">
                {{ $promotion->title }}
            </h1>
        </div>
    </div>
</section>

<section class="aboutDiscount">
    <div class="container">
        <div class="card">
            <img src="{{ asset('/assets/img/redBack.svg') }}" alt="" class="back" />
            <img src="{{ asset('/assets/img/delMan.svg') }}" alt="" class="deliver" />
            <div class="block">
                <h2 class="section_title">
                    {!! $promotion->subtitle !!}
                </h2>
            </div>
            <div class="block">
                {!! $promotion->text !!}
            </div>
        </div>
    </div>
</section>

@include('templates.promotions', ['promotions' => $promotions])

@include('templates.footer')
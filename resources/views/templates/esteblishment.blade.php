<a 
    href="{{ route('pages.category', ['category' => $zaklad->slug,]) }}" 
    @class(['eaterie-item' => true, 'closed' => $zaklad->closed()])
    data-tags="{{ json_encode($zaklad->tags->pluck('id')) }}">
    <div class="img-card">
        <img src="{{ $zaklad->imageUrl() }}" alt="" />
    </div>
    <div class="info-card">
        <div class="title">
            <!-- <div class="icon">
                <img src="./img/drink-img.jpg" alt="" />
            </div> -->
            {{ $zaklad->name }}
        </div>
        <div class="bottom">
            <div class="work-time">
                <img src="{{ asset('/assets/img/clock.svg') }}" alt="" />
                {!! $zaklad->description !!}
            </div>
            <!-- <div class="label top">
                🔥 ТОП
            </div> -->
        </div>
    </div>

    <div class="closed">
        <img src="/assets/img/lock.png" alt="">
    </div>
</a>
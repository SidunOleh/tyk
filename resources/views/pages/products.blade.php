@include('templates.header')

<section class="page-hero" style="background-image: url('{{ $category->image }}')">
    <div class="wrapper">
        <div class="container">
            <h1 class="page-hero_title">
                {{ $category->name }}
            </h1>
            <p class="subtitle workTime">
                {!! $category->description !!}
            </p>
        </div>
    </div>
</section>

<section class="dishes">
    <div class="dishes__category">
        <p class="title">
            КАТЕГОРІЇ
        </p>
        <div class="dishes__select">
            <div class="selected">
                <span>Все</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="12" viewBox="0 0 24 12" fill="none">
                    <g clip-path="url(#clip0_182_4471)">
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M11.2884 1.84306L5.63137 7.50006L7.04537 8.91406L11.9954 3.96406L16.9454 8.91406L18.3594 7.50006L12.7024 1.84306C12.5148 1.65559 12.2605 1.55028 11.9954 1.55028C11.7302 1.55028 11.4759 1.65559 11.2884 1.84306Z"
                        fill="white"
                    />
                    </g>
                    <defs>
                    <clipPath id="clip0_182_4471">
                        <rect width="12" height="24" fill="white" transform="matrix(0 -1 -1 0 24 12)" />
                    </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="dishes__menu">
                <div class="menu__item">
                    <div class="head active" data-id="{{ $category->id }}">
                        Все
                    </div>
                </div>
                @foreach ($categoryTree as $categoryItem)
                    @if ($categoryItem['children'])
                    <div class="menu__item">
                        <div class="head" data-id="{{ $categoryItem['id'] }}">
                            {{ $categoryItem['name'] }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="12" viewBox="0 0 24 12" fill="none">
                                <g clip-path="url(#clip0_182_4471)">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M11.2884 1.84306L5.63137 7.50006L7.04537 8.91406L11.9954 3.96406L16.9454 8.91406L18.3594 7.50006L12.7024 1.84306C12.5148 1.65559 12.2605 1.55028 11.9954 1.55028C11.7302 1.55028 11.4759 1.65559 11.2884 1.84306Z"
                                    fill="white"
                                />
                                </g>
                                <defs>
                                <clipPath id="clip0_182_4471">
                                    <rect width="12" height="24" fill="white" transform="matrix(0 -1 -1 0 24 12)" />
                                </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <div class="sub__menu">
                            @foreach ($categoryItem['children'] as $subcategory)
                            <div class="sub__item" data-id="{{ $subcategory['id'] }}">
                                {{ $subcategory['name'] }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="menu__item">
                        <div class="head" data-id="{{ $categoryItem['id'] }}">
                            {{ $categoryItem['name'] }}
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    @include('templates.catalog', [
        'category' => $category,
        'products' => $products,
        'cart' => $cart,
    ])
</section>

@include('templates.footer')
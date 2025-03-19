<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? "{$title} - Тук-Тук" : 'Тук-Тук' }}</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" href="{{ asset('/assets/css/main.css') }}" />
</head>

<body>
    @include('modals.login')

    <header class="header">
        <div class="container">
            <div class="header-container">
                <div class="left">
                    <a href="{{ route('pages.home') }}" class="header-logo">
                        <img src="{{ asset('/assets/img/Logo.svg') }}" alt="" />
                    </a>
                </div>
                <nav class="header-nav">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a 
                                href="{{ route('pages.home') }}" 
                                @class(['nav-link', 'active' => request()->route()?->getName() == 'pages.home',])>
                                Головна
                            </a>
                        </li>
                        <li class="nav-item">
                            <a 
                                href="{{ route('pages.about-us') }}" 
                                @class(['nav-link', 'active' => request()->route()?->getName() == 'pages.about-us',])>
                                Про нас
                            </a>
                        </li>
                        <li class="nav-item catalog">
                            <a href="{{ route('pages.zaklady') }}" class="nav-link">Заклади</a>
                        </li>
                    </ul>
                    <div class="mobile-bottom">
                        <div class="buttons">
                            @auth('web')
                            <a href="{{ route('pages.cabinet') }}" class="account_btn">
                                <img src="{{ asset('/assets/img/account.svg') }}" alt="" />
                            </a>
                            @endauth
                            @guest('web')
                            <div class="account_btn unlogged">
                                <img src="{{ asset('/assets/img/account.svg') }}" alt="" />
                            </div>
                            @endguest
                            <a href="tel:7789956555" class="phone_btn">
                                <img src="{{ asset('/assets/img/phone.svg') }}" alt="" />
                            </a>
                        </div>
                    </div>
                </nav>
                <div class="right">
                    <div class="buttons">
                        @include('templates.cart-icon', ['cartTotal' => $cartTotal])
                        <a href="tel:7789956555" class="phone_btn">
                            <img src="{{ asset('/assets/img/phone.svg') }}" alt="" />
                        </a>
                        @auth('web')
                        <a href="{{ route('pages.cabinet') }}" class="account_btn">
                            <img src="{{ asset('/assets/img/account.svg') }}" alt="" />
                        </a>
                        @endauth
                        @guest('web')
                        <div class="account_btn unlogged">
                            <img src="{{ asset('/assets/img/account.svg') }}" alt="" />
                        </div>
                        @endguest
                    </div>

                    <div class="burger-menu">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
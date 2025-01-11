<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Тук-Тук</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" href="{{ asset('/assets/css/main.css') }}" />
</head>

<body>
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
                                @class(['nav-link', 'active' => request()->route()->getName() == 'pages.home',])>
                                Головна
                            </a>
                        </li>
                        <li class="nav-item catalog">
                            <a href="{{ route('pages.zaklady') }}" class="nav-link">Заклади</a>
                        </li>
                    </ul>
                    <div class="mobile-bottom">
                        <div class="buttons">
                            <div class="cart_btn">
                                <img src="{{ asset('/assets/img/cart.svg') }}" alt="" />
                            </div>
                            <a href="tel:7789956555" class="phone_btn">
                                <img src="{{ asset('/assets/img/phone.svg') }}" alt="" />
                            </a>
                        </div>
                    </div>
                </nav>
                <div class="right">
                    <div class="buttons">
                        <a href="{{ route('pages.cart') }}" class="cart_btn">
                            <img src="{{ asset('/assets/img/cart.svg') }}" alt="" />
                        </a>
                        <a href="tel:7789956555" class="phone_btn">
                            <img src="{{ asset('/assets/img/phone.svg') }}" alt="" />
                        </a>
                        <div class="account_btn">
                            <img src="{{ asset('/assets/img/account.svg') }}" alt="" />
                        </div>
                    </div>

                    <div class="burger-menu">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
Fancybox.bind('[data-fancybox]', {});

$('.burger-menu').click(function() {
    $(this).toggleClass('active');
    $('.header-nav').toggleClass('active');
    $('body').toggleClass('lock');
    $('header').toggleClass('open');
});

$('.header .search_wrapper .search_btn').click(function() {
    $(this).closest('.search_wrapper').find('input').toggleClass('open');
    $(this).closest('.search_wrapper').find('.search_results-list').removeClass('active');
});

if ($(window).width() < 1024) {
    $('.nav-item').click(function() {
        $(this).find('.sub-menu').slideToggle();
        $(this).find('svg').toggleClass('rotate');
    });
}

$(window).on('scroll', function() {
    if ($(this).scrollTop() > 200) {
        $('header').addClass('scroll');
    } else {
        $('header').removeClass('scroll');
    }
});

$('.account_btn.unlogged').click(function() {
    $('.popUp-Wrapper.signIn').addClass('open');
});

$('.popUp-Wrapper .close').click(function() {
    $('.popUp-Wrapper').removeClass('open');
});

$('#deleteAcc').click(function() {
    $('.popUp-Wrapper.delete').addClass('open');
});
$('.btn.cancel').click(function() {
    $('.popUp-Wrapper.delete').removeClass('open');
});

$('.open-delivery').click(function() {
    $('.popUp-Wrapper.delivery').addClass('open');
});

$('.open-taxi').click(function() {
    $('.popUp-Wrapper.taxi').addClass('open');
});

$(document).ready(function() {
    $('.typeFilter-item .filter-body').on('click', function() {
        const type = $(this).data('type');
        $('.typeFilter-item .filter-body').removeClass('active');
        $(this).addClass('active');
        if (type) {
            $('.typeContent-item').hide();
            $(`.typeContent-item[data-typeContent="${type}"]`).show();
        } else {
            $('.typeContent-item').show();
        }
    });
    $('.typeFilter-item .filter-body').first().addClass('active');
    $('.typeContent-item').hide();
    $('.typeContent-item').first().show();
});

$(document).ready(function() {
    $('#delivery-time').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4);

        if (value.length >= 3) {
            $(this).val(value.slice(0, 2) + ':' + value.slice(2));
        } else {
            $(this).val(value);
        }
    });
    $('#delivery-time').on('blur', function() {
        const value = $(this).val();
        if (value.length === 5) {
            const [hours, minutes] = value.split(':').map(Number);
            if (hours > 23 || minutes > 59) {
                $(this).val('');
                alert('Введіть коректний час у форматі 00:00!');
            }
        }
    });

    $('.account_block .banner').click(function() {
        const isOpen = $(this).hasClass('open');

        $('.account_block .banner').removeClass('open');
        $('.account_block .content').slideUp();

        if (!isOpen) {
            $(this).addClass('open');
            $(this).closest('.account_block').find('.content').slideToggle();
        }
    });
});

//-----------------------SLIDERS-----------------------//
$('.hero__services-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: true,
    infinite: false,
});
if ($(window).width() <= 768) {
    $('.watch_types-list').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: $('.watch_types').find('.prev'),
        nextArrow: $('.watch_types').find('.next'),
    });
}
if ($(window).width() <= 768) {
    $('.catalog.less').each(function() {
        $(this).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: $(this).closest('section').find('.prev'),
            nextArrow: $(this).closest('section').find('.next'),
        });
    });
}
$('.discounts-slider').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    prevArrow: $('.discounts').find('.prev'),
    nextArrow: $('.discounts').find('.next'),
    dots: true,
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
            },
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
            },
        },
    ],
});
$('.reviews-list').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    prevArrow: $('.reviews').find('.prev'),
    nextArrow: $('.reviews').find('.next'),
    dots: true,
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
            },
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
            },
        },
    ],
});

$(document).ready(function() {
    const filters = $('.filter-item');
    const content = $('.content');

    filters.on('click', function() {
        const target = $(this).data('filter');

        filters.removeClass('active');
        $(this).addClass('active');

        content.each(function() {
            const content = $(this);
            if (content.data('content') === target) {
                content.addClass('active');
            } else {
                content.removeClass('active');
            }
        });
    });
});

$(document).ready(function() {
    $('.select-wrapper').on('click', function() {
        var $selectItems = $(this).siblings('.select-items');
        var $selectSelected = $(this).children('.select-selected');
        $(this).toggleClass('active');
        $selectSelected.toggleClass('active');
        $selectItems.toggleClass('select-hide');
    });

    $('.select-item').on('click', function() {
        var selectedText = $(this).text();
        var selectedValue = $(this).data('value');

        $(this).closest('.custom-select').find('.select-selected').text(selectedText);
        $(this).closest('.custom-select').find('#customSelect').val(selectedValue);

        $('.select-items').addClass('select-hide');
        $('.select-selected').removeClass('active');
        $('.select-selected').css('color', '#000');
        $('.select-wrapper').removeClass('active');
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.custom-select').length) {
            $('.select-items').addClass('select-hide');
            $('.select-selected').removeClass('active');
        }
    });
});

// const validation = new JustValidate('#main-form');
// validation
//     .addField('#name', [{
//             rule: 'required',
//             errorMessage: 'Введіть ваше ім’я',
//         },
//         {
//             rule: 'minLength',
//             value: 2,
//         },
//     ])
//     .addField('.phoneInput', [{
//             rule: 'required',
//             errorMessage: 'Введіть ваш номер телефону',
//         },
//         {
//             rule: 'minLength',
//             value: 17,
//             errorMessage: 'The field must contain a minimum of 10 characters',
//         },
//     ])
//     .addField('#email', [{
//             rule: 'required',
//             errorMessage: 'Введіть ваш email',
//         },
//         {
//             rule: 'email',
//             errorMessage: 'Неправильний email!',
//         },
//     ]);

/**
 * Jq ajax
 */
$.ajaxSetup({
    beforeSend: (xhr) =>
        xhr.setRequestHeader(
            "X-CSRF-TOKEN",
            $('meta[name="csrf-token"]').attr('content')
        ),
})

/**
 * Zaklady 
 */
$('.filter-item').on('click', function() {
    const filter = $(this).data('filter')
    $('.filter-item').removeClass('active')
    $(this).addClass('active')

    if (filter === 'all') {
        $('.eaterie-item').show()
    } else {
        $('.eaterie-item').hide()

        $('.eaterie-item').each((i, item) => {
            const tags = $(item).data('tags')
            if (tags.includes(filter)) {
                $(item).show()
            }
        })
    }
    $('.eaterieNum').text($('.eaterie-item:visible').length)
})

$('.home-eaterie .filter-item').click(() => {
    $('.eaterie-item').removeClass('hide')

    if (!$('.home-eaterie').hasClass('more')) {
        $('.eaterie-item:visible').each((i, item) => {
            if (i > 5) {
                $(item).addClass('hide')
            }
        })
    }
})

$('.home-eaterie .btn').click(() => {
    $('.home-eaterie').toggleClass('more')
    $('.home-eaterie .btn').toggleClass('hide')
    $('.eaterie-item:visible, .eaterie-item.hide').each((i, item) => {
        if (i > 5) {
            $(item).toggleClass('hide')
        }
    })
})

/**
 * Catalog
 */
$('.dishes .selected').click(function() {
    $(this).toggleClass('open')

    $('.dishes__menu').slideToggle()
})

function updateSelectedText(text) {
    $('.selected span').text(text)
}

async function loadProducts(categoryId) {
    try {
        loading($('.dishes__catalog'))
        const res = await fetch(`/catalog-html/${categoryId}`)
        const html = await res.text()
        $('.dishes__catalog').replaceWith(html)
    } finally {
        loading($('.dishes__catalog'), false)
    }
}

$('.dishes__menu .menu__item .head').on('click', function() {
    const subMenu = $(this).closest('.menu__item').find('.sub__menu')
    if (!subMenu.is(':visible')) {
        $('.menu__item .sub__menu').slideUp()
        subMenu.slideDown()
    }
    $('.dishes__menu .menu__item .head').removeClass('active')
    $('.dishes__menu .sub__item').removeClass('active')
    $(this).addClass('active')
    updateSelectedText($(this).text())
    loadProducts($(this).data('id'))
})

$('.dishes__menu .sub__item').on('click', function(e) {
    e.stopPropagation()
    $('.dishes__menu .sub__item').removeClass('active')
    $('.dishes .selected').toggleClass('open')
    $(this).addClass('active')
    updateSelectedText($(this).text())
    loadProducts($(this).data('id'))
})

$(document).on('click', '.quantity-btn--minus, .quantity-btn--plus', function() {
    const input = $(this).closest('.quantity-counter').find('input')
    let currentValue = parseInt(input.val(), 10)
    let newValue = currentValue

    if ($(this).hasClass('quantity-btn--minus')) {
        newValue -= 1
    } else {
        newValue += 1
    }

    if (newValue >= 0) {
        input.val(newValue)
        const productId = $(this).closest('.dish__item').data('id')
        changeQuantity(productId, newValue)
    }
})

/**
 * Loading
 */
function loading(el, bool = true) {
    if (bool) {
        el.addClass('loading')
    } else {
        el.removeClass('loading')
    }
}

/**
 * Cart
 */
async function changeQuantity(productId, quantity) {
    return await $.post('/cart/change-quantity', {
        product_id: productId,
        quantity,
    })
}

async function removeItemFromCart(itemId) {
    return await $.post('/cart/remove-item', {
        item_id: itemId,
    })
}

function updateCart(data) {
    for (const selector in data) {
        $(selector).replaceWith(data[selector])
    }
}

$(document).on('click', '.counter__button--increase, .counter__button--decrease', async function() {
    try {
        const input = $(this).closest('.counter').find('input')
        let currentValue = parseInt(input.val(), 10)
        let newValue = currentValue

        if ($(this).hasClass('counter__button--increase')) {
            newValue += 1
        } else {
            newValue -= 1
        }

        if (newValue > 0) {
            input.val(newValue)
            const productId = $(this).closest('.cart-item').find('.product').data('id')
            const data = await changeQuantity(productId, newValue)
            updateCart(data)
        }
    } catch (err) {
        console.error(err)
    }
})

$(document).on('click', '.cart-item .delete', async function() {
    try {
        loading($(this).closest('.cart-item'))
        const itemId = $(this).closest('.cart-item').data('id')
        const data = await removeItemFromCart(itemId)
        updateCart(data)
    } catch (err) {
        console.error(err)
    } finally {
        loading($(this).closest('.cart-item'), false)
    }
})

$('.additions .btn').click(() => {
    $('.additions .btn').toggleClass('hide')
    $('.additions-item').each((i, item) => {
        if (i > 3) {
            $(item).toggleClass('hide')
        }
    })
})

$('.additions-item .add').click(async function() {
    try {
        loading($(this).closest('.additions-item'))
        const productId = $(this).closest('.additions-item').data('id')
        const data = await changeQuantity(productId, 1)
        updateCart(data)
    } catch (err) {
        console.error(err)
    } finally {
        loading($(this).closest('.additions-item'), false)
    }
})
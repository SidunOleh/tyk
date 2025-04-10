/**
 * Setup
 */
$.ajaxSetup({
    beforeSend: xhr => {
        xhr.setRequestHeader(
            'X-CSRF-TOKEN',
            $('meta[name="csrf-token"]').attr('content')
        )
    }
})

/**
 * Functions
 */
function formatPhone(phone) {
    const matches = phone
        .replace(/\D/g, '')
        .match(/(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/)
    return !matches[2] ?
        matches[1] :
        '(' + matches[1] + ') ' +
        matches[2] +
        (matches[3] ? '-' + matches[3] : '') +
        (matches[4] ? '-' + matches[4] : '')
}

function loading(el, bool = true) {
    if (bool) {
        el.addClass('loading')
    } else {
        el.removeClass('loading')
    }
}

function resetFormErrors(form) {
    form.removeClass('error')
    form.find('.input-box').removeClass('error')
}

function showFormErrors(form, res) {
    switch (res.status) {
        case 422:
            const errors = res.responseJSON?.errors ?? []
            for (const field in errors) {
                showFieldError(form.find(`[name=${field}]`), errors[field])
            }
            break
        default:
            form.addClass('error')
            let errorEl = form.find('.error-txt')
            if (!errorEl.length) {
                errorEl = form.append('<div class="error-txt"></div>')
                errorEl = form.find('.error-txt')
            }
            errorEl.text(res.responseJSON?.message ?? 'Помилка.')
    }
}

function showFieldError(field, error) {
    const fieldBox = field.closest('.input-box')
    fieldBox.addClass('error')
    let msgEl = fieldBox.find('.validation-msg')
    if (!msgEl.length) {
        fieldBox.append('<div class="validation-msg"></div>')
        msgEl = fieldBox.find('.validation-msg')
    }
    msgEl.text(error)
}

async function refreshFragments() {
    return await $.get('/fragments/refresh')
}

async function updatePage() {
    const data = await refreshFragments()

    for (const selector in data) {
        $(selector).replaceWith(data[selector])
    }
}

async function getCatalogHtml(categoryId) {
    return await $.get(`/catalog-html/${categoryId}`)
}

async function changeCatalog(categoryId) {
    try {
        loading($('.dishes__catalog'))
        const data = await getCatalogHtml(categoryId)
        $('.dishes__catalog').replaceWith(data)
    } finally {
        loading($('.dishes__catalog'), false)
    }
}

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

async function sendCode(phone) {
    return await $.post('/send-code', { phone })
}

async function login(code) {
    return await $.post('/login', { code })
}

const resendTimer = {
    secs: 0,
    interval: null,
    start(secs) {
        if (this.interval) {
            clearInterval(this.interval)
        }

        this.secs = secs

        this.interval = setInterval(() => {
            --this.secs

            $('.timer').text(this.secs)

            if (this.secs <= 0) {
                clearInterval(this.interval)
            }
        }, 1000)
    }
}

async function logout() {
    return await $.post('/logout')
}

async function updatePersonalInfo(data) {
    return await $.post('/update-personal-info', data)
}

async function addAddress(data) {
    return await $.post('/addresses', data)
}

async function deleteAddress(data) {
    return await $.ajax({
        url: '/addresses',
        type: 'DELETE',
        data: data,
    })
}

async function checkout(data) {
    return await $.post('/checkout', data)
}

async function repearOrder(id) {
    return await $.post(`/orders/${id}/repeat`, )
}

async function deleteAccount() {
    return await $.ajax({
        url: '/delete-account',
        type: 'DELETE',
    })
}

async function handleForm(data) {
    return await $.post('/form', data)
}

/**
 * Events
 */

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

$('.home-eaterie .filter-item').on('click', () => {
    $('.eaterie-item').removeClass('hide')

    if (!$('.home-eaterie').hasClass('more')) {
        $('.eaterie-item:visible').each((i, item) => {
            if (i > 5) {
                $(item).addClass('hide')
            }
        })
    }
})

$('.home-eaterie .btn').on('click', () => {
    $('.home-eaterie').toggleClass('more')
    $('.eaterie-item').removeClass('hide')

    if (!$('.home-eaterie').hasClass('more')) {
        $('.eaterie-item:visible').each((i, item) => {
            if (i > 5) {
                $(item).addClass('hide')
            }
        })
    }
})

/**
 * Catalog
 */
$('.dishes .selected').on('click', function() {
    $(this).toggleClass('open')
    $('body').addClass('no-scroll')
    $('.dishes__menu').slideToggle()
})

$('.dishes__menu .menu__item .head').on('click', function() {
    const subMenu = $(this).closest('.menu__item').find('.sub__menu')
    if (!subMenu.is(':visible')) {
        $('.menu__item .sub__menu').slideUp()
        subMenu.slideDown()
    }
    $('.dishes__menu .menu__item .head').removeClass('active')
    $('.dishes__menu .sub__item').removeClass('active')
    $(this).addClass('active')
    $('.selected span').text($(this).text())
    $('.dishes .selected').toggleClass('open')
    if (window.innerWidth <= 1024)  {
        $('.dishes__menu').slideToggle(0)
        $('body').removeClass('no-scroll')
    }
    changeCatalog($(this).data('id'))
})

$('.dishes__menu .sub__item').on('click', function(e) {
    e.stopPropagation()
    $('.dishes__menu .sub__item').removeClass('active')
    $('.dishes .selected').toggleClass('open')
    $(this).addClass('active')
    $('.selected span').text($(this).text())
    changeCatalog($(this).data('id'))
})

$(document).on('click', '.quantity-btn--minus, .quantity-btn--plus', async function() {
    try {
        loading($(this))
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
            await changeQuantity(productId, newValue)
            await updatePage()
        }
    } catch (err) {
        console.error(err)
    } finally {
        loading($(this), false)
    }
})

/**
 * Cart
 */
$(document).on('click', '.counter__button--increase, .counter__button--decrease', async function() {
    try {
        loading($(this))
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
            await changeQuantity(productId, newValue)
            await updatePage()
        }
    } catch (err) {
        console.error(err)
    } finally {
        loading($(this), false)
    }
})

$(document).on('click', '.cart-item .delete', async function() {
    try {
        const el = $(this).closest('.cart-item')
        loading(el)
        const itemId = el.data('id')
        await removeItemFromCart(itemId)
        await updatePage()
    } catch (err) {
        console.error(err)
    } finally {
        loading($(this).closest('.cart-item'), false)
    }
})

$(document).on('click', '.additions .btn', () => {
    $('.upsells-wrapper').toggleClass('show')
})

$(document).on('click', '.additions-item .add', async function() {
    try {
        const el = $(this).closest('.additions-item')
        loading(el)
        const productId = el.data('id')
        await changeQuantity(productId, 1)
        await updatePage()
    } catch (err) {
        console.error(err)
    } finally {
        loading($(this).closest('.additions-item'), false)
    }
})

/**
 * Login
 */
$('.account_btn.unlogged').on('click', () => {
    $('#login').attr('data-event', 'cabinet')
    $('.popUp-Wrapper.signIn').addClass('open')
})

$(document).on('click', '.checkout_btn.unlogged', () => {
    $('#login').attr('data-event', 'checkout')
    $('.popUp-Wrapper.signIn').addClass('open')
})

$('.popUp-Wrapper .close').on('click', () => {
    $('.popUp-Wrapper').removeClass('open')
})

$('[type=tel]').on('input', function() {
    $(this).val(formatPhone($(this).val()))
})

$('#send-code').on('submit', async function(e) {
    try {
        e.preventDefault()
        resetFormErrors($(this))
        loading($('.signIn-popUp'))
        await sendCode($(this).find('input[name=phone]').val())
        $(this).addClass('hide')
        $('#login').removeClass('hide')
        resendTimer.start(30)
    } catch (err) {
        console.error(err)
        showFormErrors($(this), err)
    } finally {
        loading($('.signIn-popUp'), false)
    }
})

$('#login').on('submit', async function(e) {
    try {
        e.preventDefault()
        resetFormErrors($(this))
        loading($('.signIn-popUp'))
        await login($(this).find('input[name=code]').val())
        $('.popUp-Wrapper.signIn').removeClass('open')
        this.dispatchEvent(
            new CustomEvent($('#login').data('event'), {
                bubbles: true,
            })
        )
    } catch (err) {
        console.error(err)
        showFormErrors($(this), err)
    } finally {
        loading($('.signIn-popUp'), false)
    }
})

$('#login').on('cabinet', () => {
    location.href = '/cabinet'
})

$('#login').on('checkout', () => {
    location.href = '/oformlennya'
})

$('#login .resend').on('click', async() => {
    try {
        if ($('#login .timer').text() != '0') {
            return
        }

        resetFormErrors($('#login'))
        loading($('.signIn-popUp'))
        await sendCode($('#send-code input[name=phone]').val())
        resendTimer.start(30)
    } catch (err) {
        console.error(err)
        showFormErrors($('#login'), err)
    } finally {
        loading($('.signIn-popUp'), false)
    }
})

/**
 * Logout
 */
$('#logOut').on('click', async() => {
    try {
        loading($('#logOut'))
        await logout()
        location.href = '/'
    } finally {
        loading($('#logOut'), false)
    }
})

/**
 * Repeat order
 */
$('.history-item .btn').on('click', async function() {
    try {
        const el = $(this).closest('.history-item')
        loading(el)
        const id = el.data('id')
        await repearOrder(id)
        await updatePage()
    } finally {
        loading($(this).closest('.history-item'), false)
    }
})

/**
 * Update personal info 
 */
$('#update-personal-info').on('submit', async function(e) {
    try {
        e.preventDefault()
        resetFormErrors($(this))
        loading($('.pesonal-data'))
        await updatePersonalInfo($(this).serialize())
    } catch (err) {
        console.error(err)
        showFormErrors($(this), err)
    } finally {
        loading($('.pesonal-data'), false)
    }
})

/**
 * Addresses
 */
$('.autocomplete').each((i, item) => {
    new google
        .maps
        .places
        .Autocomplete(item, {
            componentRestrictions: {
                country: 'ua',
            },
            types: ['geocode'],
        })
})

$('.addNew').on('click', () => {
    $('#new-address').toggleClass('hide')
})

$('#new-address').on('submit', async function(e) {
    try {
        e.preventDefault()
        resetFormErrors($(this))
        loading($('.delivery-addressForm'))
        await addAddress($(this).serialize())
        await updatePage()
        this.reset()
    } catch (err) {
        showFormErrors($(this), err)
        console.error(err)
    } finally {
        loading($('.delivery-addressForm'), false)
    }
})

$(document).on('click', '.addressData .delete', async function() {
    try {
        const el = $(this).closest('.addressData')
        loading(el)
        await deleteAddress({ address: el.data('address') })
        await updatePage()
    } finally {
        loading($(this).closest('.addressData'), false)
    }
})

/**
 * Delete account
 */
$('#deleteAcc').on('click', () => {
    $('.popUp-Wrapper.delete').addClass('open')
})

$('.delete-popUp .btn.cancel').on('click', () => {
    $('.popUp-Wrapper.delete').removeClass('open')
})

$('.delete-popUp .btn.clear').on('click', async function() {
    try {
        loading($('.delete-popUp'))
        await deleteAccount()
        location.href = '/'
    } finally {
        loading($('.delete-popUp'), false)
    }
})

/**
 * Address history
 */
$('[data-with-history]').on('focus input', function() {
    if (!$(this).val()) {
        $(this).closest('.address-select').addClass('show-history')
    } else {
        $(this).closest('.address-select').removeClass('show-history')
    }
})

$('.addresses-history .address').on('click', function() {
    $(this).closest('.address-select').find('input').val(
        $(this).data('address')
    )
    $(this).closest('.address-select').removeClass('show-history')
})

$(document).on('click', '*', function(e) {
    $('.address-select').not($(this).closest('.address-select')).removeClass('show-history')

    if ($(this).closest('.address-select').length) {
        e.stopPropagation()
    }
})

/**
 * Checkout 
 */
$('#delivery-time').on('input', function() {
    let value = $(this).val().replace(/\D/g, '')

    if (value.length > 4) {
        value = value.slice(0, 4)
    }

    if (value.length >= 3) {
        $(this).val(value.slice(0, 2) + ':' + value.slice(2))
    } else {
        $(this).val(value)
    }
})

$('#checkout-form').on('submit', async function(e) {
    try {
        e.preventDefault()
        resetFormErrors($(this))
        loading($('.checkout .container'))
        const res = await checkout($(this).serialize())
        location.href = `/zaversheno?order=${res.id}`
    } catch (err) {
        console.error(err)
        showFormErrors($(this), err)
        window.scrollTo({ top: 0, behavior: 'smooth' })
    } finally {
        loading($('.checkout .container'), false)
    }
})

$('#checkout-form-btn').on('click', () => $('#checkout-form').trigger('submit'))

/**
 * Handle form
 */
 $('#main-form').on('submit', async function(e) {
    try {
        e.preventDefault()
        resetFormErrors($(this))
        loading($('.contactUs .wrapper'))
        await handleForm($(this).serialize())
        this.reset()
    } catch (err) {
        console.error(err)
        showFormErrors($(this), err)
    } finally {
        loading($('.contactUs .wrapper'), false)
    }
})

//=================================================================================

if (typeof Fancybox !== 'undefined') {
    Fancybox.bind('[data-fancybox]', {})
}

$('.burger-menu').on('click', function() {
    $(this).toggleClass('active')
    $('.header-nav').toggleClass('active')
    $('body').toggleClass('lock')
    $('header').toggleClass('open')
})

$('.header .search_wrapper .search_btn').on('click', function() {
    $(this).closest('.search_wrapper').find('input').toggleClass('open')
    $(this).closest('.search_wrapper').find('.search_results-list').removeClass('active')
})

if ($(window).width() < 1024) {
    $('.nav-item').on('click', function() {
        $(this).find('.sub-menu').slideToggle()
        $(this).find('svg').toggleClass('rotate')
    })
}

$(window).on('scroll', function() {
    if ($(this).scrollTop() > 200) {
        $('header').addClass('scroll')
    } else {
        $('header').removeClass('scroll')
    }
})

$('.account_block .banner').on('click', function() {
    const isOpen = $(this).hasClass('open')

    $('.account_block .banner').removeClass('open')
    $('.account_block .content').slideUp()

    if (!isOpen) {
        $(this).addClass('open')
        $(this).closest('.account_block').find('.content').slideToggle()
    }
})

$('.typeFilter-item .filter-body').on('click', function() {
    const type = $(this).data('type')
    $('.typeFilter-item .filter-body').removeClass('active')
    $(this).addClass('active')
    if (type) {
        $('.typeContent-item').hide()
        $(`.typeContent-item[data-typeContent="${type}"]`).show()
    } else {
        $('.typeContent-item').show()
    }
})
$('.typeFilter-item .filter-body').first().addClass('active')
$('.typeContent-item').hide()
$('.typeContent-item').first().show()

$('.filter-item').on('click', function() {
    const target = $(this).data('filter')

    $('.filter-item').removeClass('active')
    $(this).addClass('active')

    $('.content').each(function() {
        const content = $(this)
        if (content.data('content') === target) {
            content.addClass('active')
        } else {
            content.removeClass('active')
        }
    })
})

$('.select-wrapper').on('click', function() {
    let $selectItems = $(this).siblings('.select-items')
    let $selectSelected = $(this).children('.select-selected')
    $(this).toggleClass('active')
    $selectSelected.toggleClass('active')
    $selectItems.toggleClass('select-hide')
})

$('.select-item').on('click', function() {
    let selectedText = $(this).text()
    let selectedValue = $(this).data('value')

    $(this).closest('.custom-select').find('.select-selected').text(selectedText)
    $(this).closest('.custom-select').find('#customSelect').val(selectedValue)

    $('.select-items').addClass('select-hide')
    $('.select-selected').removeClass('active')
    $('.select-selected').css('color', '#000')
    $('.select-wrapper').removeClass('active')
})

$(document).on('click', function(e) {
    if (!$(e.target).closest('.custom-select').length) {
        $('.select-items').addClass('select-hide')
        $('.select-selected').removeClass('active')
    }
})

/**
 * Sliders
 */
$('.hero__services-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: true,
    infinite: false,
})

if ($(window).width() <= 768) {
    $('.watch_types-list').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        preletrow: $('.watch_types').find('.prev'),
        nextArrow: $('.watch_types').find('.next'),
    })
}

if ($(window).width() <= 768) {
    $('.catalog.less').each(function() {
        $(this).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            preletrow: $(this).closest('section').find('.prev'),
            nextArrow: $(this).closest('section').find('.next'),
        })
    })
}

$('.discounts-slider').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    preletrow: $('.discounts').find('.prev'),
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
})

$('.reviews-list').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    preletrow: $('.reviews').find('.prev'),
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
})

$('.home-eaterie .eaterie-filters').slick({
    slidesToShow: 7,
    slidesToScroll: 1,
    arrows: false,
    dots: false,
    infinite: false,
    responsive: [{
            breakpoint: 1250,
            settings: {
                slidesToShow: 6,
            },
        },
        {
            breakpoint: 1100,
            settings: {
                slidesToShow: 5,
            },
        },
        {
            breakpoint: 950,
            settings: {
                slidesToShow: 4,
            },
        },
        {
            breakpoint: 800,
            settings: {
                slidesToShow: 3,
            },
        },
        {
            breakpoint: 650,
            settings: {
                slidesToShow: 2,
            },
        },
        {
            breakpoint: 500,
            settings: {
                slidesToShow: 1,
            },
        },
    ],
})
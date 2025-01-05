Fancybox.bind('[data-fancybox]', {});

$('.burger-menu').click(function () {
  $(this).toggleClass('active');
  $('.header-nav').toggleClass('active');
  $('body').toggleClass('lock');
  $('header').toggleClass('open');
});

$('.header .search_wrapper .search_btn').click(function () {
  $(this).closest('.search_wrapper').find('input').toggleClass('open');
  $(this).closest('.search_wrapper').find('.search_results-list').removeClass('active');
});

if ($(window).width() < 1024) {
  $('.nav-item').click(function () {
    $(this).find('.sub-menu').slideToggle();
    $(this).find('svg').toggleClass('rotate');
  });
}

$(window).on('scroll', function () {
  if ($(this).scrollTop() > 200) {
    $('header').addClass('scroll');
  } else {
    $('header').removeClass('scroll');
  }
});

$('.account_btn').click(function () {
  $('.popUp-Wrapper.signIn').addClass('open');
});

$('.popUp-Wrapper .close').click(function () {
  $('.popUp-Wrapper').removeClass('open');
});

$('#deleteAcc').click(function () {
  $('.popUp-Wrapper.delete').addClass('open');
});
$('.btn.cancel').click(function () {
  $('.popUp-Wrapper.delete').removeClass('open');
});

$('.open-delivery').click(function () {
  $('.popUp-Wrapper.delivery').addClass('open');
});

$('.open-taxi').click(function () {
  $('.popUp-Wrapper.taxi').addClass('open');
});
// $(document).ready(function () {
//   $('.hero__item').on('mousemove', function (e) {
//     const $item = $(this);
//     const $icon = $item.find('.icon');

//     const rect = $item[0].getBoundingClientRect();

//     const x = e.clientX - rect.left;
//     const y = e.clientY - rect.top;

//     const moveX = (x / rect.width - 0.5) * 14;
//     const moveY = (y / rect.height - 0.5) * 14;
//     $icon.css('transform', `translate(${moveX}px, ${moveY}px)`);
//   });
//   $('.hero__item').on('mouseleave', function () {
//     $(this).find('.icon').css('transform', 'translate(0, 0)');
//   });
// });

$(document).ready(function () {
  $('.filter-item').on('click', function () {
    const filter = $(this).data('filter');
    $('.filter-item').removeClass('active');
    $(this).addClass('active');
    if (filter === 'all') {
      $('.eaterie-item').show();
    } else {
      $('.eaterie-item').hide();
      $(`.eaterie-item[data-category="${filter}"]`).show();
    }
    const visibleItems = $('.eaterie-item:visible').length;
    $('.eaterieNum').text(visibleItems);
  });
  const initialCount = $('.eaterie-item:visible').length;
  $('.eaterieNum').text(initialCount);
});

$(document).ready(function () {
  $('.typeFilter-item .filter-body').on('click', function () {
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

$('.dishes .selected').click(function () {
  $(this).toggleClass('open');
});

$(document).ready(function () {
  function updateSelectedText(text) {
    $('.selected span').text(text);
  }
  $('.dishes__menu .head').on('click', function () {
    const menuId = $(this).data('menu');
    const subMenu = $(this).closest('.menu__item').find('.sub__menu');
    $('.menu__item .sub__menu').slideUp();
    if (!subMenu.is(':visible')) {
      subMenu.slideToggle();
    }
    $('.dishes__menu .head').removeClass('active');
    $(this).addClass('active');
    updateSelectedText($(this).text());
    $('.dishes__catalog .catalog__item').removeClass('active').hide();
    const activeCatalog = $(`.dishes__catalog .catalog__item[data-catalog="${menuId}"]`);
    activeCatalog.addClass('active').fadeIn();
    const subMenuItems = activeCatalog.find('.subCatalog__item');
    if (subMenuItems.length > 0) {
      subMenuItems.addClass('active').show();
    } else {
      if ($(window).width() < 1024) {
        $('.dishes__menu').slideUp();
        $('.dishes .selected').toggleClass('open');
      }
    }
  });
  $('.sub__menu .sub__item').on('click', function (e) {
    e.stopPropagation();
    const submenuId = $(this).data('submenu');
    $('.sub__menu .sub__item').removeClass('active');
    $('.dishes .selected').toggleClass('open');
    $(this).addClass('active');
    updateSelectedText($(this).text());
    $('.catalog__item .subCatalog__item').removeClass('active').hide();
    $(`.catalog__item .subCatalog__item[data-subCatalog="${submenuId}"]`).addClass('active').fadeIn();
    if ($(window).width() < 1024) {
      $('.dishes__menu').slideUp();
    }
  });
  $('.selected').on('click', function () {
    if ($(window).width() < 1024) {
      $('.dishes__menu').slideToggle();
    }
  });
});

$(document).ready(function () {
  $('.counter__button--increase').on('click', function () {
    const row = $(this).closest('tr');
    const price = parseFloat(
      row
        .find('.price')
        .text()
        .replace(/[^0-9.-]+/g, '')
    );
    let quantity = parseInt(row.find('.counter__input').val());

    quantity++;
    row.find('.counter__input').val(quantity);

    const subtotal = price * quantity;
    row.find('.subtotal_table span').text(`${subtotal.toLocaleString('uk-UA', { style: 'currency', currency: 'UAH', currencyDisplay: 'symbol' })}`);
  });
  $('.counter__button--decrease').on('click', function () {
    const row = $(this).closest('tr');
    const price = parseFloat(
      row
        .find('.price')
        .text()
        .replace(/[^0-9.-]+/g, '')
    );
    let quantity = parseInt(row.find('.counter__input').val());

    if (quantity > 1) {
      quantity--;
      row.find('.counter__input').val(quantity);

      const subtotal = price * quantity;
      row.find('.subtotal_table span').text(`${subtotal.toLocaleString('uk-UA', { style: 'currency', currency: 'UAH', currencyDisplay: 'symbol' })}`);
    }
  });
});
$(document).ready(function () {
  $('.quantity-counter').each(function () {
    const $counter = $(this);
    const $minusBtn = $counter.find('.quantity-btn--minus');
    const $plusBtn = $counter.find('.quantity-btn--plus');
    const $input = $counter.find('.quantity-input');

    $minusBtn.on('click', function () {
      let currentValue = parseInt($input.val(), 10);
      if (currentValue > 0) {
        $input.val(currentValue - 1);
      }
    });

    $plusBtn.on('click', function () {
      let currentValue = parseInt($input.val(), 10);
      $input.val(currentValue + 1);
    });
  });
});

$(document).ready(function () {
  $('#delivery-time').on('input', function () {
    let value = $(this).val().replace(/\D/g, '');
    if (value.length > 4) value = value.slice(0, 4);

    if (value.length >= 3) {
      $(this).val(value.slice(0, 2) + ':' + value.slice(2));
    } else {
      $(this).val(value);
    }
  });
  $('#delivery-time').on('blur', function () {
    const value = $(this).val();
    if (value.length === 5) {
      const [hours, minutes] = value.split(':').map(Number);
      if (hours > 23 || minutes > 59) {
        $(this).val('');
        alert('Введіть коректний час у форматі 00:00!');
      }
    }
  });

  $('.account_block .banner').click(function () {
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
  $('.catalog.less').each(function () {
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
  responsive: [
    {
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
  responsive: [
    {
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

$(document).ready(function () {
  const filters = $('.filter-item');
  const content = $('.content');

  filters.on('click', function () {
    const target = $(this).data('filter');

    filters.removeClass('active');
    $(this).addClass('active');

    content.each(function () {
      const content = $(this);
      if (content.data('content') === target) {
        content.addClass('active');
      } else {
        content.removeClass('active');
      }
    });
  });
});

$(document).ready(function () {
  $('.select-wrapper').on('click', function () {
    var $selectItems = $(this).siblings('.select-items');
    var $selectSelected = $(this).children('.select-selected');
    $(this).toggleClass('active');
    $selectSelected.toggleClass('active');
    $selectItems.toggleClass('select-hide');
  });

  $('.select-item').on('click', function () {
    var selectedText = $(this).text();
    var selectedValue = $(this).data('value');

    $(this).closest('.custom-select').find('.select-selected').text(selectedText);
    $(this).closest('.custom-select').find('#customSelect').val(selectedValue);

    $('.select-items').addClass('select-hide');
    $('.select-selected').removeClass('active');
    $('.select-selected').css('color', '#000');
    $('.select-wrapper').removeClass('active');
  });

  $(document).on('click', function (e) {
    if (!$(e.target).closest('.custom-select').length) {
      $('.select-items').addClass('select-hide');
      $('.select-selected').removeClass('active');
    }
  });
});

const validation = new JustValidate('#main-form');
validation
  .addField('#name', [
    {
      rule: 'required',
      errorMessage: 'Введіть ваше ім’я',
    },
    {
      rule: 'minLength',
      value: 2,
    },
  ])
  .addField('.phoneInput', [
    {
      rule: 'required',
      errorMessage: 'Введіть ваш номер телефону',
    },
    {
      rule: 'minLength',
      value: 17,
      errorMessage: 'The field must contain a minimum of 10 characters',
    },
  ])
  .addField('#email', [
    {
      rule: 'required',
      errorMessage: 'Введіть ваш email',
    },
    {
      rule: 'email',
      errorMessage: 'Неправильний email!',
    },
  ]);

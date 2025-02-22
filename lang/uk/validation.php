<?php

return [
    'accepted' => 'Поле :attribute повинно бути прийнято.',
    'accepted_if' => 'Поле :attribute повинно бути прийнято, коли :other :value.',
    'active_url' => 'Поле :attribute повинно бути дійсною URL-адресою.',
    'after' => 'Поле :attribute повинно бути датою після :date.',
    'after_or_equal' => 'Поле :attribute повинно бути датою після або рівною :date.',
    'alpha' => 'Поле :attribute повинно містити лише літери.',
    'alpha_dash' => 'Поле :attribute повинно містити лише літери, цифри, дефіси та підкреслення.',
    'alpha_num' => 'Поле :attribute повинно містити лише літери та цифри.',
    'array' => 'Поле :attribute повинно бути масивом.',
    'ascii' => 'Поле :attribute повинно містити лише однобайтові літерно-цифрові символи та знаки.',
    'before' => 'Поле :attribute повинно бути датою до :date.',
    'before_or_equal' => 'Поле :attribute повинно бути датою до або рівною :date.',
    'between' => [
        'array' => 'Поле :attribute повинно містити від :min до :max елементів.',
        'file' => 'Поле :attribute повинно бути від :min до :max кілобайт.',
        'numeric' => 'Поле :attribute повинно бути між :min і :max.',
        'string' => 'Поле :attribute повинно містити від :min до :max символів.',
    ],
    'boolean' => 'Поле :attribute повинно бути істинним або хибним.',
    'can' => 'Поле :attribute містить неавторизоване значення.',
    'confirmed' => 'Поле підтвердження :attribute не співпадає.',
    'contains' => 'Поле :attribute не містить необхідного значення.',
    'current_password' => 'Пароль невірний.',
    'date' => 'Поле :attribute повинно бути дійсною датою.',
    'date_equals' => 'Поле :attribute повинно бути датою, рівною :date.',
    'date_format' => 'Поле :attribute повинно відповідати формату :format.',
    'decimal' => 'Поле :attribute повинно мати :decimal десяткових знаків.',
    'declined' => 'Поле :attribute повинно бути відхилено.',
    'declined_if' => 'Поле :attribute повинно бути відхилено, коли :other :value.',
    'different' => 'Поле :attribute та :other повинні бути різними.',
    'digits' => 'Поле :attribute повинно містити :digits цифр.',
    'digits_between' => 'Поле :attribute повинно містити від :min до :max цифр.',
    'dimensions' => 'Поле :attribute має некоректні розміри зображення.',
    'distinct' => 'Поле :attribute містить повторювані значення.',
    'doesnt_end_with' => 'Поле :attribute не повинно закінчуватися одним із наступних значень: :values.',
    'doesnt_start_with' => 'Поле :attribute не повинно починатися з одного з наступних значень: :values.',
    'email' => 'Поле :attribute повинно бути дійсною електронною адресою.',
    'ends_with' => 'Поле :attribute повинно закінчуватися одним із наступних значень: :values.',
    'enum' => 'Вибраний :attribute є недійсним.',
    'exists' => 'Вибраний :attribute є недійсним.',
    'extensions' => 'Поле :attribute повинно мати одне з наступних розширень: :values.',
    'file' => 'Поле :attribute повинно бути файлом.',
    'filled' => 'Поле :attribute повинно містити значення.',
    'gt' => [
        'array' => 'Поле :attribute повинно містити більше ніж :value елементів.',
        'file' => 'Поле :attribute повинно бути більшим ніж :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути більшим ніж :value.',
        'string' => 'Поле :attribute повинно містити більше ніж :value символів.',
    ],
    'gte' => [
        'array' => 'Поле :attribute повинно містити :value елементів або більше.',
        'file' => 'Поле :attribute повинно бути більшим або рівним :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути більшим або рівним :value.',
        'string' => 'Поле :attribute повинно містити :value символів або більше.',
    ],
    'hex_color' => 'Поле :attribute повинно бути дійсним шістнадцятковим кольором.',
    'image' => 'Поле :attribute повинно бути зображенням.',
    'in' => 'Вибраний :attribute є недійсним.',
    'in_array' => 'Поле :attribute повинно існувати в :other.',
    'integer' => 'Поле :attribute повинно бути цілим числом.',
    'ip' => 'Поле :attribute повинно бути дійсною IP-адресою.',
    'ipv4' => 'Поле :attribute повинно бути дійсною IPv4-адресою.',
    'ipv6' => 'Поле :attribute повинно бути дійсною IPv6-адресою.',
    'json' => 'Поле :attribute повинно бути дійсним JSON рядком.',
    'list' => 'Поле :attribute повинно бути списком.',
    'lowercase' => 'Поле :attribute повинно бути написано малими літерами.',
    'lt' => [
        'array' => 'Поле :attribute повинно містити менше ніж :value елементів.',
        'file' => 'Поле :attribute повинно бути меншим ніж :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути меншим ніж :value.',
        'string' => 'Поле :attribute повинно містити менше ніж :value символів.',
    ],
    'lte' => [
        'array' => 'Поле :attribute не повинно містити більше ніж :value елементів.',
        'file' => 'Поле :attribute повинно бути меншим або рівним :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути меншим або рівним :value.',
        'string' => 'Поле :attribute повинно містити менше або рівно :value символів.',
    ],
    'mac_address' => 'Поле :attribute повинно бути дійсною MAC-адресою.',
    'max' => [
        'array' => 'Поле :attribute не повинно містити більше ніж :max елементів.',
        'file' => 'Поле :attribute не повинно перевищувати :max кілобайт.',
        'numeric' => 'Поле :attribute не повинно бути більше ніж :max.',
        'string' => 'Поле :attribute не повинно містити більше ніж :max символів.',
    ],
    'max_digits' => 'Поле :attribute не повинно містити більше ніж :max цифр.',
    'mimes' => 'Поле :attribute повинно бути файлом одного з наступних типів: :values.',
    'mimetypes' => 'Поле :attribute повинно бути файлом одного з наступних типів: :values.',
    'min' => [
        'array' => 'Поле :attribute повинно містити хоча б :min елементів.',
        'file' => 'Поле :attribute повинно бути хоча б :min кілобайт.',
        'numeric' => 'Поле :attribute повинно бути хоча б :min.',
        'string' => 'Поле :attribute повинно містити хоча б :min символів.',
    ],
    'min_digits' => 'Поле :attribute повинно містити хоча б :min цифр.',
    'missing' => 'Поле :attribute повинно бути відсутнє.',
    'missing_if' => 'Поле :attribute повинно бути відсутнє, коли :other :value.',
    'missing_unless' => 'Поле :attribute повинно бути відсутнє, якщо тільки :other не є :value.',
    'missing_with' => 'Поле :attribute повинно бути відсутнє, коли :values присутні.',
    'missing_with_all' => 'Поле :attribute повинно бути відсутнє, коли всі :values присутні.',
    'multiple_of' => 'Поле :attribute повинно бути кратним :value.',
    'not_in' => 'Вибраний :attribute є недійсним.',
    'not_regex' => 'Формат поля :attribute є некоректним.',
    'numeric' => 'Поле :attribute повинно бути числом.',
    'password' => [
        'letters' => 'Поле :attribute повинно містити хоча б одну літеру.',
        'mixed' => 'Поле :attribute повинно містити хоча б одну велику та одну малу літеру.',
        'numbers' => 'Поле :attribute повинно містити хоча б одну цифру.',
        'symbols' => 'Поле :attribute повинно містити хоча б один символ.',
        'uncompromised' => 'Вказане :attribute з’являлося в витоку даних. Будь ласка, виберіть інше значення :attribute.',
    ],
    'present' => 'Поле :attribute повинно бути присутнє.',
    'present_if' => 'Поле :attribute повинно бути присутнє, коли :other :value.',
    'present_unless' => 'Поле :attribute повинно бути присутнє, якщо тільки :other не є :value.',
    'present_with' => 'Поле :attribute повинно бути присутнє, коли :values присутні.',
    'present_with_all' => 'Поле :attribute повинно бути присутнє, коли всі :values присутні.',
    'prohibited' => 'Поле :attribute заборонено.',
    'prohibited_if' => 'Поле :attribute заборонено, коли :other :value.',
    'prohibited_unless' => 'Поле :attribute заборонено, якщо тільки :other не є в :values.',
    'prohibits' => 'Поле :attribute забороняє присутність :other.',
    'regex' => 'Формат поля :attribute є некоректним.',
    'required' => 'Поле :attribute є обов\'язковим.',
    'required_array_keys' => 'Поле :attribute повинно містити записи для: :values.',
    'required_if' => 'Поле :attribute є обов\'язковим, коли :other :value.',
    'required_if_accepted' => 'Поле :attribute є обов\'язковим, коли :other прийнято.',
    'required_if_declined' => 'Поле :attribute є обов\'язковим, коли :other відхилено.',
    'required_unless' => 'Поле :attribute є обов\'язковим, якщо тільки :other не є в :values.',
    'required_with' => 'Поле :attribute є обов\'язковим, коли :values присутні.',
    'required_with_all' => 'Поле :attribute є обов\'язковим, коли всі :values присутні.',
    'required_without' => 'Поле :attribute є обов\'язковим, коли :values відсутні.',
    'required_without_all' => 'Поле :attribute є обов\'язковим, коли жодне з :values не присутнє.',
    'same' => 'Поле :attribute повинно збігатися з :other.',
    'size' => [
        'array' => 'Поле :attribute повинно містити :size елементів.',
        'file' => 'Поле :attribute повинно бути :size кілобайт.',
        'numeric' => 'Поле :attribute повинно бути :size.',
        'string' => 'Поле :attribute повинно містити :size символів.',
    ],
    'starts_with' => 'Поле :attribute повинно починатися з одного з наступних значень: :values.',
    'string' => 'Поле :attribute повинно бути рядком.',
    'timezone' => 'Поле :attribute повинно бути дійсною часовою зоною.',
    'unique' => 'Поле :attribute вже зайняте.',
    'uploaded' => 'Поле :attribute не вдалося завантажити.',
    'uppercase' => 'Поле :attribute повинно бути написано великими літерами.',
    'url' => 'Поле :attribute повинно бути дійсною URL-адресою.',
    'ulid' => 'Поле :attribute повинно бути дійсним ULID.',
    'uuid' => 'Поле :attribute повинно бути дійсним UUID.',

    'attributes' => [
        'email' => 'e-mail',
        'name' => 'назва',
        'password' => 'пароль',
        'phone' => 'телефон',
        'role' => 'роль',
        'first_name' => 'ім\'я',
        'last_name' => 'прізвище',
        'full_name' => 'ім\'я та прізвище',
        'tg' => 'телеграм',
        'vehicles' => 'транспорт',
        'received' => 'отримано',
        'returned' => 'повернуто',
        'images' => 'зображення',
        'description' => 'опис',
        'categories' => 'категорії',
        'price' => 'ціна',
        'slug' => 'слаг',
        'image' => 'фото',
        'addresses' => 'адреси',
        'addresses.*.address' => 'адреса',
        'addresses.*.lat' => 'широта',
        'addresses.*.lng' => 'довгота',
        'details.food_to' => 'куди',
        'details.food_to.*' => 'куди',
        'details.food_to.*.address' => 'куди',
        'details.food_to.*.lat' => 'широта',
        'details.food_to.*.lng' => 'довгота',
        'details.shipping_type' => 'тип доставки',
        'details.shipping_from.address' => 'звідки',
        'details.shipping_from.lat' => 'широта',
        'details.shipping_from.lng' => 'довгота',
        'details.shipping_to' => 'куди',
        'details.shipping_to.*' => 'куди',
        'details.shipping_to.*.address' => 'куди',
        'details.shipping_to.*.lat' => 'широта',
        'details.shipping_to.*.lng' => 'довгота',
        'details.taxi_from.address' => 'звідки',
        'details.taxi_from.lat' => 'широта',
        'details.taxi_from.lng' => 'довгота',
        'details.taxi_to' => 'куди',
        'details.taxi_to.*' => 'куди',
        'details.taxi_to.*.address' => 'куди',
        'details.taxi_to.*.lat' => 'широта',
        'details.taxi_to.*.lng' => 'довгота',
        'order_items' => 'замовлення',
        'client' => 'клієнт',
        'service' => 'сервіс',
        'type' => 'тип',
        'shipping_price' => 'сума доставки',
        'time' => 'час',
        'notes' => 'нотатки',
        'client_id' => 'клієнт',
        'duration' => 'тривалість',
        'payment_method' => 'метод оплати',
        'paid' => 'оплачено',
        'quantity' => 'к-сть',
        'additional_costs' => 'додаткові витрати',
        'status' => 'статус',
        'courier_id' => 'кур\'єр',
        'code' => 'код',
        'address' => 'адреса',
        'delivery_time' => 'час доставки',
        'title' => 'заголовок',
        'subtitle' => 'підзаголовок',
        'text' => 'текст',
        'brand' => 'марка',
        'number' => 'номер',
        'tariff_id' => 'тариф',
        'color' => 'колір',
        'fixed' => 'фіксований',
        'fixed_price' => 'фіксована ціна',
        'per_km' => 'за км', 
        'call' => 'виклик',
        'stop' => 'зупинка',
        'courier_services' => 'кур\'єрські послуги',
        'courier_services.*' => 'кур\'єрська послуга',
        'courier_services.*.service' => 'послуга',
        'courier_services.*.price' => 'ціна',
        'courier_service' => 'кур\'єрська послуга',
        'route' => 'маршрут',
        'car_id' => 'автомобіль',
        'start' => 'початок',
        'end' => 'кінець',
        'exchange_office' => 'розмінна каса',
        'comment' => 'комент',
    ],
];
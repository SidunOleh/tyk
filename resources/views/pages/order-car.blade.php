@include('templates.header', ['title' => 'Замовити авто'])

@include('templates.order-car', [
    'address_history' => auth('web')->user()->addresses ?? [],
    'bonuses' => auth('web')->user()->bonuses,
    'order' => $order,
])

@include('templates.order-car-footer')
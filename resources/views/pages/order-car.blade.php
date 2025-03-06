@include('templates.header', ['title' => 'Замовити авто'])

@include('templates.order-car', [
    'address_history' => auth('web')->user()?->addresses ?? [],
    'order' => $order,
])

@include('templates.short-footer')
@include('templates.header', ['title' => 'Замовити авто'])

@include('templates.order-car', [
    'history' => auth('web')
        ->user()
        ?->addresses ?? [],
    'order' => $order,
])

@include('templates.short-footer')
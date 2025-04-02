{{ $driverWorkShift->start->format('d.m.Y H:i') }} - {{ $driverWorkShift->end->format('d.m.Y H:i') }}
        
<b>Доставка їжі:</b> 
к-сть - {{ $driverWorkShift->food_shipping_count }}, сума - {{ format_price($driverWorkShift->food_shipping_total) }}
<b>Кур'єр:</b> 
к-сть - {{ $driverWorkShift->shipping_count }}, сума - {{ format_price($driverWorkShift->shipping_total) }}
<b>Таксі:</b> 
к-сть - {{ $driverWorkShift->taxi_count }}, сума - {{ format_price($driverWorkShift->taxi_total) }}
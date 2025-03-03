{{ $driverWorkShift->start->format('d.m.Y H:i') }} - {{ $driverWorkShift->end->format('d.m.Y H:i') }}
        
<b>Доставка їжі:</b> 
к-сть - {{ $driverWorkShift->food_shipping_count }}, сума - {{ number_format($driverWorkShift->food_shipping_total, 2) }} грн
<b>Кур'єр:</b> 
к-сть - {{ $driverWorkShift->shipping_count }}, сума - {{ number_format($driverWorkShift->shipping_total, 2) }} грн
<b>Таксі:</b> 
к-сть - {{ $driverWorkShift->taxi_count }}, сума - {{ number_format($driverWorkShift->taxi_total, 2) }} грн
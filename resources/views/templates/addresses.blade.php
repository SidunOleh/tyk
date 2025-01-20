<div class="save-address">
    @foreach ($addresses ?? [] as $i => $address)
    <div 
        class="addressData" 
        data-index="{{ $i }}">
        <div>
            <span>{{ $address['address'] }}</span>
        </div>
        <div class="actions">
            <div class="delete">
                Видалити
            </div>
        </div>
    </div>
    @endforeach

    @if (! $addresses)
        <div class="empty">
            Немає жодної адреси
        </div>
    @endif
</div>
<div class="popUp-Wrapper signIn">
    <div class="signIn-popUp popUp">
        <div class="close"><img src="{{ asset('/assets/img/close.svg') }}" alt="" /></div>
        <p class="title">Вхід у кабінет</p>
        <form action="">
            <input type="text" name="phone" placeholder="Ваш номер телефону*" />
            <!-- забрати display:none -->
            <div class="confirmationCode" style="display: none">
                <p class="text_18">На Ваш номер надіслано СМС повідомлення з підтвердженням телефону, введіть код нижче</p>
                <input type="text" placeholder="Ваш код*" />
                <div class="resend">Надіслати код ще раз</div>
                <p class="readout">Через <span class="timer">30</span></p>
            </div>
            <button type="submit" class="btn">Вхід</button>
        </form>
    </div>
</div>
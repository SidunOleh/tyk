<div class="popUp-Wrapper signIn">
    <div class="signIn-popUp popUp">
        <div class="close">
            <img src="{{ asset('/assets/img/close.svg') }}" alt="" />
        </div>

        <p class="title">
            Вхід у кабінет
        </p>

        <form id="send-code">
            <div class="input-box">
                <input 
                    type="tel" 
                    name="phone" 
                    placeholder="(090) 111-11-11"/>
            </div>

            <button type="submit" class="btn">
                Надіслати код
            </button>
        </form>

        <form id="login" class="hide">
            <div class="confirmationCode">
                <p class="text_18">
                    На Ваш номер надіслано СМС повідомлення з підтвердженням телефону, введіть код нижче
                </p>
                <div class="input-box">
                    <input 
                        type="text" 
                        name="code"
                        placeholder="Ваш код"/>
                </div>
                <div class="resend">
                    Надіслати код ще раз
                </div>
                <p class="readout">
                    Через <span class="timer">30</span>
                </p>
            </div>

            <button type="submit" class="btn">
                Вхід
            </button>
        </form>
    </div>
</div>
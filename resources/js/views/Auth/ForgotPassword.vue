<template>

    <a-modal 
        :open="true"
        :mask="false"
        :closable="false"
        :footer="null">

        <a-form layout="vertical">

            <a-form-item
                :required="true"
                label="E-mail"
                has-feedback
                :validate-status="errors['email'] ? 'error' : ''"
                :help="errors?.email">
                <a-input
                    placeholder="Введіть e-mail"
                    v-model:value="credentials.email"/>
            </a-form-item>

            <a-button
                :loading="loading"
                @click="send">
                Надіслати
            </a-button>

            <div style="text-align: center;">
                <router-link :to="{name: 'login'}">
                    Назад
                </router-link>
            </div>
            
        </a-form>

    </a-modal>

</template>

<script>
import { message } from 'ant-design-vue'
import authApi from '../../api/auth'

export default {
    data() {
        return {
            credentials: {
                email: null,
            },
            errors: {},
            loading: false,
        }
    },
    methods: {
        async send() {
            try {
                this.loading = true
                this.errors = {}
                await authApi.sendResetLink(this.credentials.email)
                message.success(`Посилання для зміни пароля відправлено ${this.credentials.email}.`)
                this.credentials.email = null
            } catch (err) {
                if (err?.response?.status == 422) {
                    this.errors = err?.response?.data?.errors
                } else {
                    message.error(err?.response?.data?.message ?? err.message)
                }
            } finally {
                this.loading = false
            }
        }
    }
}
</script>

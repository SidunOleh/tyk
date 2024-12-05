<template>

    <a-modal 
        :open="true"
        :mask="false"
        :closable="false"
        :footer="null">

        <a-flex 
            :vertical="true"
            :gap="25">

            <img 
                src="@img/logo.svg"
                style="align-self: center; background: rgb(175 172 172); padding: 5px; border-radius: 5px; width: 150px;">

            <a-form layout="vertical">

                <a-form-item
                    label="E-mail"
                    :required="true"
                    has-feedback
                    :validate-status="errors['email'] ? 'error' : ''"
                    :help="errors?.email">
                    <a-input
                        placeholder="Введіть e-mail"
                        v-model:value="credentials.email"/>
                </a-form-item>

                <a-form-item
                    label="Пароль"
                    :required="true"
                    has-feedback
                    :validate-status="errors['password'] ? 'error' : ''"
                    :help="errors?.password">
                    <a-input-password
                        placeholder="Введіть пароль"
                        v-model:value="credentials.password"/>
                </a-form-item>

                <a-button
                    :loading="loading"
                    @click="login">
                    Ввійти
                </a-button>

                <br>
                <br>

                <div style="text-align: center;">
                    <router-link :to="{name: 'password.forgot'}">
                        Забув пароль?
                    </router-link>
                </div>
                
            </a-form>

        </a-flex>

    </a-modal>

</template>

<script>
import { message } from 'ant-design-vue'
import { auth } from '../../helpers/helpers'

export default {
    data() {
        return {
            credentials: {
                email: null,
                password: null,
            },
            errors: {},
            loading: false,
        }
    },
    methods: {
        async login() {
            try {
                this.loading = true
                this.errors = {}
                await auth.login(this.credentials)
                location.href = '/'
            } catch (err) {
                if (err?.response?.status == 422) {
                    this.errors = err?.response?.data?.errors
                } else {
                    message.error(err?.response?.data?.message ?? err.message)
                }
            } finally {
                this.loading = false
            }
        },
    },
}
</script>
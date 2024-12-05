<template>

    <a-modal 
        :open="true"
        :mask="false"
        :closable="false"
        :footer="null">

        <a-form layout="vertical">

            <a-form-item
                label="Пароль"
                :required="true"
                has-feedback
                :validate-status="errors['password'] ? 'error' : ''"
                :help="errors?.password">
                <a-input-password
                    type="password"
                    placeholder="Введіть пароль"
                    v-model:value="credentials.password"/>
            </a-form-item>

            <a-form-item
                label="Підтвердження пароля"
                :required="true"
                has-feedback
                :validate-status="errors['password_confirmation'] ? 'error' : ''"
                :help="errors?.password_confirmation">
                <a-input-password
                    type="password"
                    placeholder="Введіть пароль повторно"
                    v-model:value="credentials.password_confirmation"/>
            </a-form-item>

            <a-button
                :loading="loading"
                @click="reset">
                Змінити пароль
            </a-button>
            
        </a-form>

    </a-modal>

</template>

<script>
import { message, } from 'ant-design-vue'
import authApi from '../../api/auth'

export default {
    data() {
        return {
            credentials: {
                password: null,
                password_confirmation: null,
            },
            loading: false,
            errors: {},
        }
    },
    methods: {
        async reset() {
            try {
                this.loading = true
                this.errors = {}
                this.credentials.email = this.$route.query.email
                this.credentials.token = this.$route.query.token
                await authApi.resetPassword(this.credentials)
                message.success('Пароль успішно змінений.')
                this.$router.push({name: 'login',})
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

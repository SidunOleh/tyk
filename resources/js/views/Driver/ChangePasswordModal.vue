<template>
    <a-modal 
        title="Змінити пароль"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item
                label="Пароль"
                :required="action == 'create'"
                has-feedback
                :validate-status="errors['password'] ? 'error' : ''"
                :help="errors.password">
                <a-flex
                    :vertical="true" 
                    :gap="5">
                    <a-input-password
                        placeholder="Введіть пароль"
                        :visible="true"
                        v-model:value="data.password"/>
                    <a-button @click="generatePassword">
                        Створити
                    </a-button>
                </a-flex>
            </a-form-item>

            <a-button   
                type="primary"
                :loading="loading"
                @click="changePassword">
                Змінити
            </a-button>

        </a-form>

    </a-modal>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/driver'

export default {
    props: [
        'open',
    ],
    data() {
        return {
            data: {
                password: '',
            },
            errors: {},
            loading: false,
        }
    },    
    methods: {
        generatePassword() {
            this.data.password = Math.random().toString(36).substring(2)
        },
        async changePassword() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.changePassword(this.data.password)
                message.success('Успішно збережено.')
                this.$emit('changePassword')
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
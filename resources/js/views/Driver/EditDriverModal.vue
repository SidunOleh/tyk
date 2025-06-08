<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item 
                label="Ім'я"
                :required="true"
                has-feedback
                :validate-status="errors['first_name'] ? 'error' : ''"
                :help="errors.first_name">
                <a-input
                    placeholder="Введіть ім'я"
                    v-model:value="data.first_name"/>
            </a-form-item>

            <a-form-item 
                label="Прізвище"
                :required="true"
                has-feedback
                :validate-status="errors['last_name'] ? 'error' : ''"
                :help="errors.last_name">
                <a-input
                    placeholder="Введіть прізвище"
                    v-model:value="data.last_name"/>
            </a-form-item>

            <a-form-item 
                label="E-mail"
                :required="true"
                has-feedback
                :validate-status="errors['email'] ? 'error' : ''"
                :help="errors.email">
                <a-input
                    placeholder="Введіть e-mail"
                    v-model:value="data.email"/>
            </a-form-item>

            <a-form-item 
                label="Телефон"
                :required="true"
                has-feedback
                :validate-status="errors['phone'] ? 'error' : ''"
                :help="errors.phone">
                <a-input
                    prefix="+38"
                    placeholder="(097) 123-45-67"
                    v-model:value="data.phone"
                    :maxlength="15"
                    @change="() => data.phone = formatPhone(data.phone)"/>
            </a-form-item>

            <a-form-item 
                label="Телеграм"
                has-feedback
                :validate-status="errors['tg'] ? 'error' : ''"
                :help="errors.tg">
                <a-input
                    prefix="@"
                    placeholder="Введіть телеграм"
                    v-model:value="data.tg"/>
            </a-form-item>

            <a-button   
                type="primary"
                :loading="loading"
                @click="edit">
                Зберегти
            </a-button>

        </a-form>

    </a-modal>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/driver'
import { 
    formatPhone,
} from '../../helpers/helpers'

export default {
    props: [
        'title',
        'open',
        'item',
    ],
    data() {
        return {
            data: {
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
                tg: '',
            },
            errors: {},
            loading: false,
        }
    },    
    methods: {
        formatPhone,
        async edit() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.edit(this.data)
                message.success('Успішно збережено.')
                this.$emit('edit')
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
    mounted() {
        if (this.item) {
            this.data.first_name = this.item.courier.first_name
            this.data.last_name = this.item.courier.last_name
            this.data.email = this.item.email
            this.data.phone = this.item.courier.phone
            this.data.tg = this.item.courier.tg
        }
    },
}
</script>
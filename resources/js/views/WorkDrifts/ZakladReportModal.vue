<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item 
                label="Повернута сума"
                :required="true"
                has-feedback
                :validate-status="errors['returned_amount'] ? 'error' : ''"
                :help="errors.returned_amount">
                <a-input-number
                    style="width: 100%"
                    placeholder="Введіть повернуту суму"
                    :min="0"
                    v-model:value="data.returned_amount"/>
            </a-form-item>

            <a-form-item 
                label="Метод оплати"
                :required="true"
                has-feedback
                :validate-status="errors['payment_method'] ? 'error' : ''"
                :help="errors.payment_method">
                <a-select
                    style="width: 100%"
                    placeholder="Виберіть метод оплати"
                    :options="paymentMethodOptions"
                    v-model:value="data.payment_method">
                </a-select>
            </a-form-item>

            <a-form-item 
                label="Комент"
                has-feedback
                :validate-status="errors['comment'] ? 'error' : ''"
                :help="errors.comment">
                <a-textarea
                    placeholder="Введіть комент"
                    v-model:value="data.comment"/>
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
import api from '../../api/work-shifts'
import { 
    confirmPopup, 
    formatPrice,
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
                returned_amount: 0,
                payment_method: null,
                comment: '',
            },
            paymentMethods: [
                'Карта',
                'Готівка',
            ],
            errors: {},
            loading: false,
        }
    },    
    computed: {
        paymentMethodOptions() {
            return this.paymentMethods.map(paymentMethod => {
                return {
                    value: paymentMethod, 
                }
            })
        },
    },
    methods: {
        confirmPopup,
        formatPrice,
        async edit() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.editZakladReport(
                    this.item.id, 
                    this.data
                )
                message.success('Успішно збережено.')
                this.$emit('edit')
                this.$emit('update:open', false)
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
            this.data = JSON.parse(JSON.stringify(this.item))
        }
    },
}
</script>
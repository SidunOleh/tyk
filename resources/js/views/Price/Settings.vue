<template>
    <a-spin :spinning="loading">
        <a-form layout="vertical">

            <a-form-item 
                label="Виклик"
                :required="true"
                has-feedback
                :validate-status="errors['call'] ? 'error' : ''"
                :help="errors.call">
                <a-input-number
                    style="width: 100%;"
                    placeholder="Введіть ціну за виклик"
                    :min="0"
                    v-model:value="data.call"/>
            </a-form-item>

            <a-form-item 
                label="Зупинка"
                :required="true"
                has-feedback
                :validate-status="errors['stop'] ? 'error' : ''"
                :help="errors.stop">
                <a-input-number
                    style="width: 100%;"
                    placeholder="Введіть ціну за зупинку"
                    :min="0"
                    v-model:value="data.stop"/>
            </a-form-item>

            <a-form-item 
                label="Виклик за межами Золочева"
                :required="true"
                has-feedback
                :validate-status="errors['outside_zolochiv'] ? 'error' : ''"
                :help="errors.outside_zolochiv">
                <a-input-number
                    style="width: 100%;"
                    placeholder="Введіть ціну за виклик за межами Золочева"
                    :min="0"
                    v-model:value="data.outside_zolochiv"/>
            </a-form-item>

            <a-button
                type="primary"
                :loading="loading"
                @click="save">
                Зберегти
            </a-button>

        </a-form>
    </a-spin>

    <a-divider>
        Кур'єрські послуги    
    </a-divider>

    <CourierServicesList/>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/price'
import CourierServicesList from '../CourierServices/List.vue'

export default {
    components: {
        CourierServicesList,
    },
    data() {
        return {
            data: {
                call: 0,
                stop: 0,
            },
            errors: {},
            loading: false,
        }
    },
    methods: {
        async fetchSettings() {
            try {
                this.loading = true
                this.errors = {}
                const data = await api.getSettings()
                Object.assign(this.data, data.settings)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        async save() {
            try {
                this.loading = true
                await api.saveSettings(this.data)
                message.success('Успішно збережено.')
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
        this.fetchSettings()
    },
}
</script>
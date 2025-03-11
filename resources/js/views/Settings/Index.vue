<template>
    <a-form layout="vertical">
        <a-collapse v-model:activeKey="activeKey">
            <a-collapse-panel 
                key="1"
                header="Бонуси">
                <a-form-item label="Доставка їжі">
                    <a-input-number
                        style="width: 100%;"
                        placeholder="Бонуси за доставку їжі"
                        :min="0"
                        v-model:value="data.bonuses_food_shipping"/>
                </a-form-item>
                <a-form-item label="Кур'єр">
                    <a-input-number
                        style="width: 100%;"
                        placeholder="Бонуси за кур'єр"
                        :min="0"
                        v-model:value="data.bonuses_shipping"/>
                </a-form-item>
                <a-form-item label="Таксі">
                    <a-input-number
                        style="width: 100%;"
                        placeholder="Бонуси за таксі"
                        :min="0"
                        v-model:value="data.bonuses_taxi"/>
                </a-form-item>
            </a-collapse-panel>
        </a-collapse>

        <a-button 
            style="margin-top: 20px;"
            type="primary"
            :loading="loading"
            @click="save">
            Зберегти
        </a-button>
    </a-form>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/settings'

export default {
    data() {
        return {
            activeKey: [1],
            data: {
                bonuses_food_shipping: 0,
                bonuses_shipping: 0,
                bonuses_taxi: 0,
            },
            loading: false,
        }
    },  
    methods: {
        async fetchSetting() {
            try {
                this.loading = true
                const data = await api.fetch()
                this.data = Object.assign(this.data, data.settings)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        async save() {
            try {
                this.loading = true
                const res = await api.save(this.data)
                message.success('Успішно збережено.')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
    },
    mounted() {
        this.fetchSetting()
    },
}
</script>
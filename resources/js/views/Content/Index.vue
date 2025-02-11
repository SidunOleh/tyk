<template>
    <a-form layout="vertical">
        <a-collapse v-model:activeKey="activeKey">
            <a-collapse-panel key="1" header="Головна">
                <a-tabs>
                    <a-tab-pane key="1" tab="Перша секція">
                        <a-form-item label="Заголовок">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.home_first_title"/>
                        </a-form-item>
                        <a-form-item label="Підзаголовок">
                            <a-input
                                placeholder="Введіть підзаголовок"
                                v-model:value="data.home_first_subtitle"/>
                        </a-form-item>
                        <a-form-item label="Заголовок(Доставка їжі)">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.home_food_title"/>
                        </a-form-item>
                        <a-form-item label="Підзаголовок(Доставка їжі)">
                            <a-input
                                placeholder="Введіть підзаголовок"
                                v-model:value="data.home_food_subtitle"/>
                        </a-form-item>
                        <a-form-item label="Заголовок(Кур'єр)">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.home_courier_title"/>
                        </a-form-item>
                        <a-form-item label="Підзаголовок(Кур'єр)">
                            <a-input
                                placeholder="Введіть підзаголовок"
                                v-model:value="data.home_courier_subtitle"/>
                        </a-form-item>
                        <a-form-item label="Заголовок(Таксі)">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.home_taxi_title"/>
                        </a-form-item>
                        <a-form-item label="Підзаголовок(Таксі)">
                            <a-input
                                placeholder="Введіть підзаголовок"
                                v-model:value="data.home_taxi_subtitle"/>
                        </a-form-item>
                    </a-tab-pane>
                    <a-tab-pane key="2" tab="Заклади">
                        <a-form-item label="Заголовок">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.home_zaklady_title"/>
                        </a-form-item>
                    </a-tab-pane>
                    <a-tab-pane key="3" tab="Акції">
                        <a-form-item label="Заголовок">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.home_promotion_title"/>
                        </a-form-item>
                    </a-tab-pane>
                    <a-tab-pane key="4" tab="Кур'єр">
                        <a-form-item label="Заголовок">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.home_courier_title"/>
                        </a-form-item>
                        <a-form-item label="Елементи">
                            <CourierItems :items="data.home_courier_items"/>
                        </a-form-item>
                    </a-tab-pane>
                    <a-tab-pane key="5" tab="Додаток">
                        <a-form-item label="Заголовок">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.home_app_title"/>
                        </a-form-item>
                        <a-form-item label="Підзаголовок">
                            <a-input
                                placeholder="Введіть підзаголовок"
                                v-model:value="data.home_app_subtitle"/>
                        </a-form-item>
                    </a-tab-pane>
                    <a-tab-pane key="6" tab="Кроки">
                        <a-form-item label="Заголовок">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.home_steps_title"/>
                        </a-form-item>

                        <a-form-item label="Елементи">
                            <StepItems :items="data.home_step_items"/>
                        </a-form-item>
                    </a-tab-pane>
                    <a-tab-pane key="7" tab="Відгуки">
                        <a-form-item label="Заголовок">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.home_reviews_title"/>
                        </a-form-item>
                    </a-tab-pane>
                </a-tabs>
            </a-collapse-panel>
            <a-collapse-panel key="2" header="Про нас">
                <a-tabs>
                    <a-tab-pane key="1" tab="Перша секція">
                        <a-form-item label="Заголовок">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.about_first_title"/>
                        </a-form-item>
                        <a-form-item label="Зображення">
                            <Upload v-model:uploaded="data.about_first_img"/>
                        </a-form-item>
                    </a-tab-pane>
                    <a-tab-pane key="2" tab="Про нас">
                        <a-form-item label="Заголовок">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.about_info_title"/>
                        </a-form-item>
                        <a-form-item label="Текст">
                            <QuillEditor 
                                style="min-height: 200px;"
                                contentType="html"
                                toolbar="full"
                                v-model:content="data.about_info_text"></QuillEditor>
                        </a-form-item>
                        <a-form-item label="Елементи">
                            <InfoItems :items="data.about_info_items"/>
                        </a-form-item>
                    </a-tab-pane>
                    <a-tab-pane key="3" tab="Приклади">
                        <a-form-item label="Заголовок">
                            <a-input
                                placeholder="Введіть заголовок"
                                v-model:value="data.about_examples_title"/>
                        </a-form-item>
                        <a-form-item label="Елементи">
                            <ExampleItems :items="data.about_examples_items"/>
                        </a-form-item>
                    </a-tab-pane>
                </a-tabs>
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
import api from '../../api/content'
import Upload from '../components/Upload.vue'
import CourierItems from './CourierItems.vue'
import StepItems from './StepItems.vue'
import InfoItems from './InfoItems.vue'
import ExampleItems from './ExampleItems.vue'

export default {
    components: {
        Upload,
        CourierItems,
        StepItems,
        InfoItems,
        ExampleItems,
    },
    data() {
        return {
            activeKey: [1],
            data: {
                home_first_title: '',
                home_first_subtitle: '',
                home_first_food_title: '',
                home_first_food_subtitle: '',
                home_first_courier_title: '',
                home_first_courier_subtitle: '',
                home_first_taxi_title: '',
                home_first_taxi_subtitle: '',
                home_zaklady_title: '',
                home_promotion_title: '',
                home_courier_title: '',
                home_courier_items: [],
                home_app_title: '',
                home_app_subtitle: '',
                home_app_img: null,
                home_step_title: '',
                home_step_items: [],
                home_reviews_title: '',
                home_reviews_items: [],
                about_first_title: '',
                about_first_img: null,
                about_info_title: '',
                about_info_text: '',
                about_info_items: [],
                about_examples_title: '',
                about_examples_items: [],
            },
            loading: false,
        }
    },
    methods: {
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
    async mounted() {
        try {
            this.loading = true
            const data = await api.fetch()
            this.data = Object.assign(this.data, data)
        } catch (err) {
            message.error(err?.response?.data?.message ?? err.message)
        } finally {
            this.loading = false
        }
    },
}
</script>
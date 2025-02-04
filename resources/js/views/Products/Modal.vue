<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item 
                label="Фото"
                has-feedback
                :validate-status="errors['image'] ? 'error' : ''"
                :help="errors.image">
                <Upload v-model:uploaded="data.image"/>
            </a-form-item>

            <a-form-item 
                label="Назва"
                :required="true"
                has-feedback
                :validate-status="errors['name'] ? 'error' : ''"
                :help="errors.name">
                <a-input
                    placeholder="Введіть назву"
                    v-model:value="data.name"
                    @change="e => data.slug = slugify(data.name, {lower: true,})"/>
            </a-form-item>

            <a-form-item 
                label="Слаг"
                :required="true"
                has-feedback
                :validate-status="errors['slug'] ? 'error' : ''"
                :help="errors.slug">
                <a-input
                    placeholder="Введіть слаг"
                    v-model:value="data.slug"/>
            </a-form-item>

            <a-form-item 
                label="Ціна"
                :required="true"
                has-feedback
                :validate-status="errors['price'] ? 'error' : ''"
                :help="errors.price">
                <a-input-number 
                    placeholder="Введіть ціну"
                    :min="0"
                    v-model:value="data.price" 
                    prefix="₴" 
                    style="width: 100%"/>
            </a-form-item>

            <a-form-item
                label="Категорії"
                :required="true"
                has-feedback
                :validate-status="errors['categories'] ? 'error' : ''"
                :help="errors.categories">
                <a-tree-select
                    placeholder="Виберіть категорії"
                    :tree-data="categoryOptions"
                    :treeCheckStrictly="true"
                    :value="data.categories"
                    @change="checked => data.categories = checked.map(i => i.value)"/>
            </a-form-item>

            <a-form-item 
                label="Інгредієнти"
                has-feedback
                :validate-status="errors['ingredients'] ? 'error' : ''"
                :help="errors.ingredients">
                <a-textarea
                    placeholder="Введіть інгредієнти"
                    v-model:value="data.ingredients"/>
            </a-form-item>

            <a-form-item 
                label="Вага"
                has-feedback
                :validate-status="errors['weight'] ? 'error' : ''"
                :help="errors.weight">
                <a-input
                    placeholder="Введіть вагу"
                    v-model:value="data.weight"/>
            </a-form-item>

            <a-form-item 
                label="Oпис"
                has-feedback
                :validate-status="errors['description'] ? 'error' : ''"
                :help="errors.description">
                <a-textarea
                    placeholder="Введіть опис"
                    v-model:value="data.description"/>
            </a-form-item>

            <a-button
                type="primary"
                :loading="loading"
                @click="action == 'create' ? create() : edit()">
                Зберегти
            </a-button>

        </a-form>

    </a-modal>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/products'
import Upload from '../components/Upload.vue'
import slugify from 'slugify'

export default {
    props: [
        'title',
        'open',
        'action',
        'item',
        'categories',
    ],
    components: {
        Upload,
    },
    data() {
        return {
            data: {
                image: null,
                name: '',
                regular_price: '',
                short_description: '',
                categories: [],
            },
            errors: {},
            loading: false,
        }
    },
    computed: {
        categoryOptions() {
            const options = this.makeCategoryOptions(this.categories, null)
            
            return options
        },
    },      
    methods: {
        slugify,
        async create() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.create(this.data)
                message.success('Успішно створено.')
                this.$emit('create')
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
        async edit() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.edit(this.data.id, this.data)
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
        makeCategoryOptions(categories, parent) {
            let options = []
            categories.forEach(category => {
                if (category.parent_id === parent) {
                    options.push({
                        label: category.name,
                        value: category.id,
                        children: this.makeCategoryOptions(
                            categories, 
                            category.id
                        )
                    })
                }
            })

            return options
        },
    },
    mounted() {
        if (this.item) {
            this.data = JSON.parse(JSON.stringify(this.item))
            this.data.categories = this.data.categories.map(category => category.id)
        }
    },
}
</script>
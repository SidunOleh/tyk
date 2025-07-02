<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

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
                label="Батьківська категорія"
                has-feedback
                :validate-status="errors['parent_id'] ? 'error' : ''"
                :help="errors.parent_id">
                <a-tree-select
                    placeholder="Виберіть категорію"
                    :tree-data="categoryOptions"
                    v-model:value="data.parent_id"/>
            </a-form-item>

            <a-form-item 
                label="Фото"
                has-feedback
                :validate-status="errors['image'] ? 'error' : ''"
                :help="errors.image">
                <Upload v-model:uploaded="data.image"/>
            </a-form-item>

            <a-form-item
                label="Теги"
                has-feedback
                :validate-status="errors['tags'] ? 'error' : ''"
                :help="errors.tags">
                <a-select
                    placeholder="Виберіть теги"
                    mode="tags"
                    :options="tagOptions"
                    v-model:value="data.tags">
                    <template #dropdownRender="{ menuNode: menu }">
                        <component :is="menu" />
                        <a-divider style="margin: 10px 0" />
                        <a-button 
                            style="width: 100%;"
                            @click="showTagsModal = true">
                            Керування
                        </a-button>
                    </template>
                </a-select>
            </a-form-item>

            <a-form-item 
                label="Супутні товари"
                has-feedback
                :validate-status="errors['upsells'] ? 'error' : ''"
                :help="errors['upsells']">
                <a-select
                    style="width: 100%"
                    placeholder="Знайдіть товар"
                    mode="tags"
                    :filter-option="false"
                    :options="productOptions"
                    :showSearch="true"
                    v-model:value="data.upsells"
                    @search="fetchProducts">
                    <template 
                        v-if="products.fetching" 
                        #notFoundContent>
                        <a-spin 
                            style="width: 100%" 
                            size="small"/>
                    </template>
                </a-select>
            </a-form-item>

            <a-form-item 
                label="Видимість"
                has-feedback
                :validate-status="errors['visible'] ? 'error' : ''"
                :help="errors.visible">
                <a-switch v-model:checked="data.visible"/>
            </a-form-item>

            <a-form-item 
                label="Опис"
                has-feedback
                :validate-status="errors['description'] ? 'error' : ''"
                :help="errors.description">
                <a-textarea
                    placeholder="Введіть опис"
                    v-model:value="data.description"/>
            </a-form-item>

            <Schedule 
                v-if="data.parent_id === null"
                v-model:value="data.schedule"
                :errors="errors"/>

            <a-form-item 
                label="Метазаголовок"
                has-feedback
                :validate-status="errors['meta_title'] ? 'error' : ''"
                :help="errors.meta_title">
                <a-input
                    placeholder="Введіть заголовок"
                    v-model:value="data.meta_title"/>
            </a-form-item>

            <a-form-item 
                label="Метаопис"
                has-feedback
                :validate-status="errors['meta_description'] ? 'error' : ''"
                :help="errors.meta_description">
                <a-textarea
                    placeholder="Введіть опис"
                    v-model:value="data.meta_description"/>
            </a-form-item>

            <a-button
                type="primary"   
                :loading="loading"
                @click="action == 'create' ? create() : edit()">
                Зберегти
            </a-button>

        </a-form>

    </a-modal>

    <TagsModal 
        v-if="showTagsModal"
        v-model:open="showTagsModal"
        :tags="tags"/>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/categories'
import Upload from '../components/Upload.vue'
import slugify from 'slugify'
import TagsModal from './Tags/Modal.vue'
import productsApi from '../../api/products'
import Schedule from '../components/Schedule.vue'

export default {
    props: [
        'title',
        'open',
        'action',
        'item',
        'categories',
        'tags',
    ],
    components: {
        Upload, 
        TagsModal,
        Schedule,
    },
    data() {
        return {
            data: {
                name: '',
                parent_id: null,
                image: null,
                visible: true,
                tags: [],
                upsells: [],
                description: '',
                schedule: null,
                meta_title: '',
                meta_description: '',
            },
            products: {
                data: [],
                fetching: false,
            },
            errors: {},
            showTagsModal: false,
            loading: false,
        }
    },
    computed: {
        categoryOptions() {
            let categories = this.categories
            
            if (this.action == 'edit') {
                categories = categories.filter(category => category.id != this.data.id)
            }

            const options = this.makeCategoryOptions(categories, null)
            
            return options
        },
        tagOptions() {
            return this.tags.map(tag => {
                return {
                    label: tag.name,
                    value: tag.id,
                }
            })  
        },
        productOptions() {
            return this.products.data.map(product => {
                let label = product.name
                label += `, ${product.categories.filter(cat => ! cat.parent_id).map(cat => cat.name).join(', ')}`

                return {
                    label: label,
                    value: product.id, 
                }
            })
        },
    },      
    methods: {
        slugify,
        async fetchProducts(s) {
            this.products.fetching = true
            const res = await productsApi.search(s)
            this.products.data = res
            this.products.fetching = false
        },
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
            this.data.tags = this.data.tags.map(tag => tag.id)
            this.products.data = this.item.upsells
            this.data.upsells = this.data.upsells.map(product => product.id)
        }
    },
}
</script>
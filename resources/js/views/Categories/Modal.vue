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
                <Upload 
                    :maxCount="1"
                    :uploaded="uploaded"
                    @changeFileList="changeFileList"/>
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

            <a-button
                :loading="loading"
                @click="action == 'create' ? create() : edit()">
                Зберегти
            </a-button>

        </a-form>

    </a-modal>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/categories'
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
                name: '',
                parent_id: null,
                image: null,
                description: '',
            },
            uploaded: [],
            errors: {},
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
        changeFileList(info) {
            const images = []
            info.fileList.forEach(file => {
                if (file.status == 'done') {
                    images.push(file.response.path)
                }

                if (file.status == 'uploaded') {
                    images.push(file.path)
                }
            })

            this.data.image = images[0] ?? null
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

            if (this.item.image) {
                this.uploaded.push({
                    url: this.item.image,
                    path: this.item.image,
                    status: 'uploaded',
                })
           } 
        }
    },
}
</script>
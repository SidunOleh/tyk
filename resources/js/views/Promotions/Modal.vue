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
                <Upload 
                    :maxCount="1"
                    :uploaded="uploaded"
                    @changeFileList="changeFileList"/>
            </a-form-item>

            <a-form-item 
                label="Заголовок"
                :required="true"
                has-feedback
                :validate-status="errors['title'] ? 'error' : ''"
                :help="errors.title">
                <a-input
                    placeholder="Введіть заголовок"
                    v-model:value="data.title"
                    @change="e => data.slug = slugify(data.title, {lower: true,})"/>
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
                label="Підзаголовок"
                :required="true"
                has-feedback
                :validate-status="errors['subtitle'] ? 'error' : ''"
                :help="errors.subtitle">
                <a-input
                    placeholder="Введіть підзаголовок"
                    v-model:value="data.subtitle"/>
            </a-form-item>

            <a-form-item 
                label="Текст"
                :required="true"
                has-feedback
                :validate-status="errors['text'] ? 'error' : ''"
                :help="errors.text">
                <QuillEditor 
                    style="min-height: 200px;"
                    contentType="html"
                    toolbar="full"
                    v-model:content="data.text"></QuillEditor>
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
import api from '../../api/promotions'
import Upload from '../components/Upload.vue'
import slugify from 'slugify'

export default {
    props: [
        'title',
        'open',
        'action',
        'item',
    ],
    components: {
        Upload,
    },
    data() {
        return {
            data: {
                image: '',
                title: '',
                slug: '',
                subtitle: '',
                text: '',
            },
            uploaded: [],
            errors: {},
            loading: false,
        }
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
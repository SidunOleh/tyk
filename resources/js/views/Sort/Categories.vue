<template>
    <a-spin :spinning="loading">
        <CategoryList :list="list"/>

        <a-button
            type="primary"
            @click="save">
            Save
        </a-button>
    </a-spin>
</template>

<script>
import { message } from 'ant-design-vue'
import CategoryList from './CategoryList.vue'
import api from '../../api/categories'

export default {
    components: {
        CategoryList
    },
    data() {
        return {
            list: [],
            loading: false,
        }
    },
    methods: {
        async getCategoriesTree() {
            try {
                this.loading = true
                this.list = await api.tree()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        async save() {
            try {
                this.loading = true
                await api.reorder({tree: this.list})
                message.success('Успішно збережено')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
    },
    mounted() {
        this.getCategoriesTree()
    },
}
</script>
<template>

    <a-button 
        style="margin-bottom: 15px;"
        type="primary"
        @click="create.open = true">
        Створити
    </a-button>

    <Table 
        ref="table"
        :categories="categories"
        @edit="record => {edit.record = record; edit.open = true;}"
        @history="record => {history.record = record; history.open = true;}"/>

    <Modal
        v-if="create.open"
        title="Створення категорії"
        action="create"
        :categories="categories"
        :tags="tags"
        v-model:open="create.open"
        @create="() => {$refs.table.updateData(); this.fetchAllCategories();}"/>

    <Modal
        v-if="edit.open"
        title="Редагування категорії"
        action="edit"
        :categories="categories"
        :item="edit.record"
        :tags="tags"
        v-model:open="edit.open"
        @edit="() => {$refs.table.updateData(); this.fetchAllCategories();}"/>

    <History
        v-model:open="history.open"
        :history="history.record?.history"/>

</template>

<script>
import { message } from 'ant-design-vue'
import Table from './Table.vue'
import Modal from './Modal.vue'
import categoriesApi from '../../api/categories'
import History from '../components/History.vue'

export default {
    components: {
        Table,
        Modal,
        History,
    },
    data() {
        return {
            tags: [],
            create: {
                open: false,
            },
            edit: {
                open: false,
                record: null,
            },
            history: {
                open: false,
                record: null,
            },
            categories: [],
        }
    },
    methods: {
        async fetchAllCategories() {
            try {
                const res = await categoriesApi.all() 
                this.categories = res.categories
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async fetchCategoryTags() {
            try {
                this.tags = await categoriesApi.getTags() 
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    mounted() {
        this.fetchAllCategories()
        this.fetchCategoryTags()
    },
}
</script>

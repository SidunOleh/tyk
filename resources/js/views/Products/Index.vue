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
        title="Створення товару"
        action="create"
        :categories="categories"
        v-model:open="create.open"
        @create="$refs.table.updateData()"/>

    <Modal
        v-if="edit.open"
        title="Редагування товару"
        action="edit"
        :categories="categories"
        :item="edit.record"
        v-model:open="edit.open"
        @edit="$refs.table.updateData()"/>

    <History
        v-model:open="history.open"
        :history="history.record?.history"/>

</template>

<script>
import { message } from 'ant-design-vue'
import Table from './Table.vue'
import Modal from './Modal.vue'
import api from '../../api/products'
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
    },
    mounted() {
        this.fetchAllCategories()
    },
}
</script>

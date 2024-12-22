<template>
    <a-button 
        style="margin-bottom: 15px;"
        type="primary"
        @click="create.open = true">
        Створити
    </a-button>

    <Table
        ref="table"
        @create="create.open = true"
        @edit="record => {edit.record = record; edit.open = true;}"
        @history="record => {history.record = record; history.open = true;}"
        @createOrder="record => {client.record = record; client.open = true;}"
        @editOrder="$refs.table.updateData()"
        @deleteOrder="$refs.table.updateData()"/>

    <Modal
        v-if="create.open"
        title="Створення клієнта"
        action="create"
        v-model:open="create.open"
        @create="$refs.table.updateData()"/>
        
    <Modal
        v-if="edit.open"
        title="Редагування клієнта"
        action="edit"
        v-model:open="edit.open"
        :item="edit.record"
        @edit="$refs.table.updateData()"/>

    <OrderModal
        v-if="client.open"
        title="Створення замовлення"
        action="create"
        v-model:open="client.open"
        :client="client.record"
        @create="$refs.table.updateData()"/>

    <History
        v-model:open="history.open"
        :history="history.record?.history"/>
</template>

<script>
import Table from './Table.vue'
import Modal from './Modal.vue'
import OrderModal from '../Orders/Modal/Modal.vue'
import History from '../components/History.vue'

export default {
    components: {
        Table, 
        Modal,
        History,
        OrderModal,
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
            client: {
                open: false,
                record: null,
            },
            history: {
                open: false,
                record: null,
            },
        }
    },
}
</script>

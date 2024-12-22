<template>

    <a-button 
        style="margin-bottom: 15px;"
        type="primary"
        @click="create.open = true">
        Створити
    </a-button>

    <Table
        ref="table"
        @cashes="record => {cashes.record = record; cashes.open = true;}"
        @create="create.open = true"
        @edit="record => {edit.record = record; edit.open = true;}"
        @history="record => {history.record = record; history.open = true;}"/>

    <Modal
        v-if="create.open"
        title="Створення кур'єра"
        v-model:open="create.open"
        action="create"
        @create="$refs.table.updateData()"/>
        
    <Modal
        v-if="edit.open"
        title="Редагування кур'єра"
        v-model:open="edit.open"
        action="edit"
        :item="edit.record"
        @edit="$refs.table.updateData()"/>

    <CashesModal
        v-if="cashes.open"
        :title="`Каса ${cashes.record.first_name} ${cashes.record.last_name}`"
        v-model:open="cashes.open"
        :courier="cashes.record"
        @create="$refs.table.updateData()"
        @edit="$refs.table.updateData()"
        @delete="$refs.table.updateData()"/>

    <History
        v-model:open="history.open"
        :history="history.record?.history"/>

</template>

<script>
import Table from './Table.vue'
import Modal from './Modal.vue'
import CashesModal from './CashesModal.vue'
import History from '../components/History.vue'

export default {
    components: {
        Table, 
        Modal, 
        CashesModal,
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
            cashes: {
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

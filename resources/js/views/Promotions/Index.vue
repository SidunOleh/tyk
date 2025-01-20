<template>

    <a-button 
        style="margin-bottom: 15px;"
        type="primary"
        @click="create.open = true">
        Створити
    </a-button>

    <Table 
        ref="table"
        @edit="record => {edit.record = record; edit.open = true;}"/>

    <Modal
        v-if="create.open"
        title="Створення акції"
        action="create"
        v-model:open="create.open"
        @create="$refs.table.updateData()"/>

    <Modal
        v-if="edit.open"
        title="Редагування акції"
        action="edit"
        :item="edit.record"
        v-model:open="edit.open"
        @edit="$refs.table.updateData()"/>

</template>

<script>
import { message } from 'ant-design-vue'
import Table from './Table.vue'
import Modal from './Modal.vue'

export default {
    components: {
        Table,
        Modal,
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
        }
    },
}
</script>

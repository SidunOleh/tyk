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
        @edit="record => {edit.record = record; edit.open = true;}"/>

    <Modal
        v-if="create.open"
        title="Створення користувача"
        v-model:open="create.open"
        action="create"
        @create="$refs.table.updateData()"/>
        
    <Modal
        v-if="edit.open"
        title="Редагування користувача"
        v-model:open="edit.open"
        action="edit"
        :item="edit.record"
        @edit="$refs.table.updateData()"/>

</template>

<script>
import Table from './Table.vue'
import Modal from './Modal.vue'

export default {
    components: {
        Table, Modal,
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

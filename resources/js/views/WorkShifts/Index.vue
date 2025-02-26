<template>
    <Table
        ref="table"
        @zakladReport="report => {zakladReport.record = report; zakladReport.open = true;}"/>

    <ZakladReportModal
        v-if="zakladReport.open"
        :title="`Звіт по закладу ${zakladReport.record.zaklad.name}`"
        v-model:open="zakladReport.open"
        :item="zakladReport.record"
        @edit="$refs.table.updateData()"/>
</template>

<script>
import Table from './Table.vue'
import ZakladReportModal from './ZakladReportModal.vue'

export default {
    components: {
        Table, 
        ZakladReportModal,
    },
    data() {
        return {
            zakladReport: {
                open: false,
                record: null,
            },
        }
    },
}
</script>

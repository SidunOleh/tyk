<template>
    <a-table
        :columns="columns"
        :dataSource="data"
        :pagination="{pageSize: 15}"
        :bordered="true">

        <template #expandedRowRender="{ record }">
            <OrderDescription :order="record"/>
        </template>

        <template #bodyCell="{column, record}">

            <template v-if="column.key === 'type'">
                {{ record.type }}
            </template>

            <template v-if="column.key === 'total'">
                {{ formatPrice(record.total) }}
            </template>

            <template v-if="column.key === 'time'">
                {{ formatDate(record.time) }}
            </template>

            <template v-if="column.key === 'status'">
                <a-tag :color="orderStatusColor(record.status)">
                    {{ record.status }}
                </a-tag>
            </template>

            <template v-if="column.key === 'paid'">
                {{ record.paid ? 'Так' : 'Ні' }}
            </template>

            <template v-if="column.key === 'created_at'">
                {{ formatDate(record.created_at) }}
            </template>

            <template v-if="column.key === 'actions'">
                <a-dropdown>
                    <a 
                        class="ant-dropdown-link" 
                        @click.prevent>
                        Дії
                        <DownOutlined/>
                    </a>
                    <template #overlay>
                        <a-menu>
                            <a-menu-item @click="history.open = true; history.record = record;">
                                <a href="javascript:;">
                                    Історія
                                </a>
                            </a-menu-item>
                            <a-menu-item @click="edit.open = true; edit.record = record;">
                                <a href="javascript:;">
                                    Редагувати
                                </a>
                            </a-menu-item>
                            <a-menu-item 
                                danger
                                @click="confirmPopup(() => deleteRecord(record), `Ви впевнені що хочете видалити ${record.type}(${formatPrice(record.total)})?`)">
                                <a href="javascript:;">
                                    Видалити
                                </a>
                            </a-menu-item>
                        </a-menu>
                    </template>
                </a-dropdown>
            </template>

        </template>

    </a-table>

    <Modal
        v-if="edit.open"
        title="Редагування замовлення"
        v-model:open="edit.open"
        action="edit"
        :item="edit.record"
        @edit="$emit('edit')"/>
    
    <History
        v-model:open="history.open"
        :history="history.record?.history"/>
</template>

<script>
import { message, } from 'ant-design-vue'
import {
    DownOutlined,
} from '@ant-design/icons-vue'
import api from '../../api/orders'
import { 
    confirmPopup, 
    formatPrice,
    formatDate,
    orderStatusColor,
} from '../../helpers/helpers'
import Modal from '../Orders/Modal/Modal.vue'
import History from '../components/History.vue'
import OrderDescription from '../Orders/OrderDescription.vue'

export default {
    props: [
        'data',
    ],
    components: {
        DownOutlined,
        Modal,
        History,
        OrderDescription,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Тип',
                    key: 'type',
                },
                {
                    title: 'Повна сума',
                    key: 'total',
                    sorter: (a, b) => a.total - b.total,
                },
                {
                    title: 'Час',
                    key: 'time',
                },
                {
                    title: 'Статус',
                    key: 'status',
                },
                {
                    title: 'Оплачено',
                    key: 'paid',
                },
                {
                    title: 'Створено',
                    key: 'created_at',
                },
                {
                    key: 'actions',
                    align: 'center',
                },
            ],
            edit: {
                open: false,
                record: null,
            },
            history: {
                open: false,
                record: null,
            },
        }
    },
    methods: {
        confirmPopup,
        formatPrice,
        formatDate,
        orderStatusColor,
        async deleteRecord(record) {
            try {
                await api.delete(record.id)
                message.success('Успішно видалено')
                this.$emit('delete')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    mounted() {
        this.data.map(item => item.key = item.id)
    },
}
</script>

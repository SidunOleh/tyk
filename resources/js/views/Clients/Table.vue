<template>

    <a-table
        :columns="columns"
        :dataSource="data.data"
        :pagination="{
            pageSize: query.perpage, 
            total: data.meta?.total, 
            onChange: (page, size) => query.perpage = size
        }"
        :bordered="true"
        :loading="loading"
        :rowSelection="{onChange: (selectedRowKeys, selectedRows) => selected = selectedRows}"
        @change="changeQuery">

        <template #expandedRowRender="{ record }">
            <a-descriptions 
                style="margin-top: 10px;"
                size="small"
                bordered
                :column="1">
                <a-descriptions-item label="Ім'я">
                    {{ record.first_name }}
                </a-descriptions-item>
                <a-descriptions-item label="Прізвище">
                    {{ record.last_name }}
                </a-descriptions-item>
                <a-descriptions-item label="Телефон">
                    {{ record.phone }}
                </a-descriptions-item>
                <a-descriptions-item label="Адреси">
                    <a-tag  
                        v-for="address in record.addresses"
                        :bordered="false">
                        {{ address }}
                    </a-tag>
                </a-descriptions-item>    
                <a-descriptions-item label="Бонуси">
                    {{ record.bonuses }}
                </a-descriptions-item>           
            </a-descriptions>
        </template>

        <template #title>
            <a-flex
                :wrap="'wrap'"
                :justify="'space-between'"
                :gap="5">

                <a-flex
                    :wrap="'wrap'" 
                    :gap="5">
                    <a-select 
                        class="bulk-select"
                        placeholder="Масові дії"
                        :options="bulkOptions"
                        v-model:value="bulkAction"/>
                    <a-button @click="doBulk">
                        Застосувати
                    </a-button>
                </a-flex>

                <a-input-search
                    style="display: block; max-width: 400px;"
                    placeholder="Пошук"
                    v-model:value="query.s"
                    @search="updateData"/>
            </a-flex>
        </template>

        <template #footer>
            <a-flex
                :wrap="'wrap'" 
                :gap="5">
                <a-select 
                    class="bulk-select"
                    placeholder="Масові дії"
                    :options="bulkOptions"
                    v-model:value="bulkAction"/>
                <a-button 
                    @click="doBulk">
                    Застосувати
                </a-button>
            </a-flex>
        </template>

        <template #bodyCell="{column, record}">

            <template v-if="column.key === 'first_name'">
                {{ record.first_name }}
            </template>

            <template v-if="column.key === 'last_name'">
                {{ record.last_name }}
            </template>

            <template v-if="column.key === 'phone'">
                {{ record.phone }}
            </template>

            <template v-if="column.key === 'addresses'">
                <a-tag 
                    v-for="address in record.addresses"
                    :bordered="false">
                    {{ address }}
                </a-tag>
            </template>

            <a-tooltip>
                <template #title>
                    Редагувати
                </template>

                <template v-if="column.key === 'edit'">
                    <span
                        style="cursor: pointer;"
                        @click="$emit('edit', record)">
                        <EditOutlined/>
                    </span>
                </template>
            </a-tooltip>

            <a-tooltip>
                <template #title>
                    Видалити
                </template>
    
                <template v-if="column.key === 'delete'">
                    <span
                        style="cursor: pointer;"
                        @click="confirmPopup(() => deleteRecord(record), `Ви впевнені що хочете видалити ${record.email}?`)">
                        <DeleteOutlined/>
                    </span>
                </template>
            </a-tooltip>

        </template>

    </a-table>

</template>

<script>
import { message, } from 'ant-design-vue'
import {
    EditOutlined,
    DeleteOutlined,
} from '@ant-design/icons-vue'
import api from '../../api/clients'
import { confirmPopup, } from '../../helpers/helpers'

export default {
    components: {
        EditOutlined,
        DeleteOutlined,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Ім\'я',
                    key: 'first_name',
                    sorter: true,
                },
                {
                    title: 'Прізвище',
                    key: 'last_name',
                    sorter: true,
                },
                {
                    title: 'Телефон',
                    key: 'phone',
                },
                {
                    title: 'Адреси',
                    key: 'addresses',
                },
                {
                    key: 'edit',
                    align: 'center',
                },
                {
                    key: 'delete',
                    align: 'center',
                },
            ],
            data: {},
            bulkOptions: [
                {
                    label: 'Видалити',
                    value: 'delete',
                },
            ],
            bulkAction: null,
            selected: [],
            data: {},
            query: {
                page: 1,
                perpage: 15,
                orderby: 'created_at',
                order: 'DESC',
                s: '',
                filters: {},
            },
            loading: false,
        }
    },
    methods: {
        confirmPopup,
        async updateData() {
            try {
                this.loading = true
                this.data = await api.fetch(this.query) 
                this.data.data.map(item => item.key = item.id)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        changeQuery(pagination, filters, sorter) {
            this.query.page = pagination.current
    
            this.query.filters = filters

            if (sorter.columnKey) {
                this.query.orderby = sorter.columnKey
            }
            
            if (sorter.order) {
                this.query.order = sorter.order
                    .replace('ascend', 'ASC')
                    .replace('descend', 'DESC')
            }
        },
        async deleteRecord(record) {
            try {
                await api.delete(record.id)
                message.success('Успішно видалено')
                this.updateData()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async bulkDelete() {
            try {
                await api.bulkDelete(this.selected.map(row => row.id))
                this.selected = []
                this.updateData()
                message.success('Успішно видалено')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        doBulk() {
            if (
                this.bulkAction == 'delete' && 
                this.selected.length
            ) {
                confirmPopup(this.bulkDelete, 'Ви впевнені що хочете видалити обраних клієнтів?')
            }
        },
    },
    watch: {
        query: {
            handler() {
               this.updateData()
            },
            deep: true,
        },
    },
    mounted() {
       this.updateData()
    },
}
</script>

<template>

    <a-table
        :columns="columns"
        :dataSource="data.data"
        :pagination="{
            pageSize: query.perpage, 
            total: data.meta?.total, 
            onChange: (page, size) => query.perpage = size
        }"
        :loading="loading"
        :bordered="true"
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
                <a-descriptions-item label="Телеграм">
                    {{ record.tg }}
                </a-descriptions-item>
                <a-descriptions-item label="Транспорт">
                    <a-tag 
                        v-for="vehicle in record.vehicles"
                        :bordered="false">
                        {{ vehicle }}
                    </a-tag>
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

            <template v-if="column.key === 'tg'">
                {{ record.tg }}
            </template>

            <template v-if="column.key === 'vehicles'">
                <a-tag 
                    v-for="vehicle in record.vehicles"
                    :bordered="false">
                    {{ vehicle }}
                </a-tag>
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
                            <a-menu-item @click="$emit('cashes', record)">
                                <a href="javascript:;">
                                    Каса
                                </a>
                            </a-menu-item>
                            <a-menu-item @click="$emit('history', record)">
                                <a href="javascript:;">
                                    Історія
                                </a>
                            </a-menu-item>
                            <a-menu-item @click="$emit('edit', record)">
                                <a href="javascript:;">
                                    Редагувати
                                </a>
                            </a-menu-item>
                            <a-menu-item 
                                danger
                                @click="confirmPopup(() => deleteRecord(record), `Ви впевнені що хочете видалити ${record.first_name} ${record.last_name}?`)">
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

</template>

<script>
import { message, } from 'ant-design-vue'
import {
    DownOutlined,
} from '@ant-design/icons-vue'
import api from '../../api/couriers'
import { confirmPopup, } from '../../helpers/helpers'

export default {
    components: {
        DownOutlined,
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
                    title: 'Телеграм',
                    key: 'tg',
                },
                {
                    title: 'Траспорт',
                    key: 'vehicles',
                    filters: [
                        {
                            text: 'автомобіль',
                            value: 'автомобіль',
                        },
                        {
                            text: 'скутер',
                            value: 'скутер',
                        },
                    ],
                },
                {
                    key: 'actions',
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
                confirmPopup(this.bulkDelete, 'Ви впевнені що хочете видалити обраних користувачів?')
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

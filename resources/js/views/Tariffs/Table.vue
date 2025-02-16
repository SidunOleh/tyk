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
                size="small"
                bordered
                :column="1">
                <a-descriptions-item label="Назва">
                    {{ record.name }}
                </a-descriptions-item>
                <a-descriptions-item label="Фіксований">
                    {{ record.fixed ? 'Так' : 'Ні' }}
                </a-descriptions-item>
                <a-descriptions-item 
                    v-if="record.fixed"
                    label="Фіксована ціна">
                    {{ formatPrice(record.fixed_price) }}
                </a-descriptions-item>
                <a-descriptions-item 
                    v-if="! record.fixed"
                    label="Ціна за км">
                    {{ formatPrice(record.per_km) }}
                </a-descriptions-item>
                <a-descriptions-item label="Дефолтний">
                    {{ record.default ? 'Так' : 'Ні' }}
                </a-descriptions-item>
                <a-descriptions-item label="Колір">
                    <div :style="{width: '20px', height: '20px', 'border-radius': '50%', background: record.color,}">
                    </div>
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

            <template v-if="column.key === 'name'">
                {{ record.name }}
            </template>

            <template v-if="column.key === 'fixed'">
                {{ record.fixed ? 'Так' : 'Ні' }}
            </template>

            <template v-if="column.key === 'fixed_price' && record.fixed">
                {{ formatPrice(record.fixed_price) }}
            </template>

            <template v-if="column.key === 'per_km' && ! record.fixed">
                {{ formatPrice(record.per_km) }}
            </template>

            <template v-if="column.key === 'default'">
                {{ record.default ? 'Так' : 'Ні' }}
            </template>

            <template v-if="column.key === 'color'">
                <div :style="{width: '20px', height: '20px', 'border-radius': '50%', background: record.color,}">
                </div>
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
                            <a-menu-item @click="confirmPopup(() => setAsDefault(record), `Ви впевнені що хочете зробити тариф ${record.name} дефолтним?`)">
                                <a href="javascript:;">
                                    Зробити дефолтним
                                </a>
                            </a-menu-item>
                            <a-menu-item @click="$emit('edit', record)">
                                <a href="javascript:;">
                                    Редагувати
                                </a>
                            </a-menu-item>
                            <a-menu-item 
                                danger
                                @click="confirmPopup(() => deleteRecord(record), `Ви впевнені що хочете видалити ${record.name}?`)">
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
import api from '../../api/tariffs'
import { 
    confirmPopup, 
    formatPrice,
} from '../../helpers/helpers'
import {
    DownOutlined,
} from '@ant-design/icons-vue'

export default {
    components: {
        DownOutlined,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Назва',
                    key: 'name',
                },
                {
                    title: 'Фіксований',
                    key: 'fixed',
                },
                {
                    title: 'Фіксована ціна',
                    key: 'fixed_price',
                    sorter: true,
                },
                {
                    title: 'Ціна за км',
                    key: 'per_km',
                    sorter: true,
                },
                {
                    title: 'Дефолтний',
                    key: 'default',
                },
                {
                    title: 'Колір',
                    key: 'color',
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
        formatPrice,
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
        async setAsDefault(record) {
            try {
                await api.setAsDefault(record.id)
                message.success('Успішно змінено')
                this.updateData()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
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
                confirmPopup(this.bulkDelete, 'Ви впевнені що хочете видалити обрані тарифи?')
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

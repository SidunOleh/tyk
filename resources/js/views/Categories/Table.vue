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
                <a-descriptions-item label="Фото">
                    <a-image 
                        v-if="record.image"
                        :width="100" 
                        :height="100"
                        style="object-fit: cover;"
                        :src="record.image"/>
                </a-descriptions-item>
                <a-descriptions-item label="Назва">
                    {{ record.name }}
                </a-descriptions-item>
                <a-descriptions-item label="Слаг">
                    {{ record.slug }}
                </a-descriptions-item>
                <a-descriptions-item label="Батьківська категорія">
                    <a-tag :bordered="false">
                        {{ categories.filter(category => category.id == record.parent_id)[0]?.name }}
                    </a-tag>
                </a-descriptions-item>
                <a-descriptions-item label="Опис">
                    <div v-html="record.description?.replace(/\n/g, '<br/>')">
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

            <template v-if="column.key === 'image'">
                <a-image 
                    v-if="record.image"
                    :width="100" 
                    :height="100"
                    style="object-fit: cover;"
                    :src="record.image"/>
            </template>

            <template v-if="column.key === 'name'">
                {{ record.name }}
            </template>

            <template v-if="column.key === 'parent'">
                <a-tag :bordered="false">
                    {{ categories.filter(category => category.id == record.parent_id)[0]?.name }}
                </a-tag>
            </template>

            <template v-if="column.key === 'description'">
                <div v-html="record.description?.replace(/\n/g, '<br/>')">
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
import api from '../../api/categories'
import { confirmPopup, } from '../../helpers/helpers'
import {
    DownOutlined,
} from '@ant-design/icons-vue'

export default {
    props: [
        'categories',
    ],
    components: {
        DownOutlined,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Фото',
                    key: 'image',
                },
                {
                    title: 'Назва',
                    key: 'name',
                    sorter: true,
                },
                {
                    title: 'Батьківська категорія',
                    key: 'parent',
                },
                {
                    title: 'Опис',
                    key: 'description',
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
                confirmPopup(this.bulkDelete, 'Ви впевнені що хочете видалити обрані категорії?')
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

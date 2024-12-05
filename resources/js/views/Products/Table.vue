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
                    <div v-html="record.name">
                    </div>
                </a-descriptions-item>
                <a-descriptions-item label="Ціна">
                    <div v-html="record.price_html">
                    </div>     
                </a-descriptions-item>
                <a-descriptions-item label="Категорії">
                    <a-tag 
                        v-for="category in record.categories"
                        :bordered="false">
                        {{ category.name }}
                    </a-tag> 
                </a-descriptions-item>
                <a-descriptions-item label="Опис">
                    {{ record.description }}             
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
                    v-if="record.images[0]?.src"
                    style="width: 100px;"
                    :src="record.images[0].src"/>
            </template>

            <template v-if="column.key === 'title'">
                <a-typography-link 
                    :href="record.permalink"
                    v-html="record.name">
                </a-typography-link>
            </template>

            <template v-if="column.key === 'price'">
                <div v-html="record.price_html">
                </div>
            </template>

            <template v-if="column.key === 'categories'">
                <a-tag 
                    v-for="category in record.categories"
                    :bordered="false">
                    {{ category.name }}
                </a-tag>
            </template>

        </template>

    </a-table>

</template>

<script>
import { message, } from 'ant-design-vue'
import api from '../../api/products'

export default {
    data() {
        return {
            columns: [
                {
                    title: 'Фото',
                    key: 'image',
                },
                {
                    title: 'Назва',
                    key: 'title',
                    sorter: true,
                },
                {
                    title: 'Ціна',
                    key: 'price',
                },
                {
                    title: 'Категорії',
                    key: 'categories',
                },
            ],
            data: {},
            bulkOptions: [
            ],
            bulkAction: null,
            selected: [],
            data: {},
            query: {
                page: 1,
                perpage: 15,
                orderby: 'date',
                order: 'desc',
                s: '',
                filters: {},
            },
            loading: false,
        }
    },
    methods: {
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
                    .replace('ascend', 'asc')
                    .replace('descend', 'desc')
            }
        },
        doBulk() {
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

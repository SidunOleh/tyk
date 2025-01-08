<template>
    <a-spin :spinning="loading">
        <a-flex
            :justify="'space-between'"
            :align="'center'"
            :gap="5">
            <a-typography-title :level="3">
                Категорія - {{ category?.name }} ({{ this.list.length }})
            </a-typography-title>

            <router-link :to="{name: 'sort.categories'}">
                Назад
            </router-link>
        </a-flex>

        <ProductsList :list="list"/>

        <a-button
            type="primary"
            @click="save">
            Save
        </a-button>
    </a-spin>
</template>

<script>
import { message } from 'ant-design-vue'
import ProductsList from './ProductsList.vue'
import api from '../../api/categories'

export default {
    components: {
        ProductsList
    },
    data() {
        return {
            list: [],
            category: null,
            loading: false,
        }
    },
    methods: {
        async getCategoryProducts() {
            try {
                this.loading = true
                const res = await api.getProducts(
                    this.$route.params.id
                )
                this.list = res.products
                this.category = res.category
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        async save() {
            try {
                this.loading = true
                await api.reorderProducts(this.$route.params.id, {products: this.list})
                message.success('Успішно збережено')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
    },
    mounted() {
        this.getCategoryProducts()
    },
}
</script>
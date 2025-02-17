<template>
    <a-form-item 
        label="Замовлення"
        :required="true"
        has-feedback
        :validate-status="errors['order_items'] ? 'error' : ''"
        :help="errors['order_items']">
        <a-flex :gap="5">
            <a-select
                style="width: 30%;"
                placeholder="Знайдіть заклад"
                :allowClear="true"
                :filter-option="false"
                :options="zakladOptions"
                :showSearch="true"
                :showArrow="false"
                v-model:value="zaklady.selected"
                @search="fetchZaklady">
                <template 
                    v-if="zaklady.fetching" 
                    #notFoundContent>
                    <a-spin 
                        style="width: 100%" 
                        size="small"/>
                </template>
            </a-select>
            <a-select
                style="width: 70%"
                placeholder="Знайдіть товар"
                :allowClear="true"
                :filter-option="false"
                :options="productOptions"
                :showSearch="true"
                :showArrow="false"
                v-model:value="products.selected"
                @search="fetchProducts"
                @select="addToCart">
                <template 
                    v-if="products.fetching" 
                    #notFoundContent>
                    <a-spin 
                        style="width: 100%" 
                        size="small"/>
                </template>
            </a-select>
    </a-flex>
    </a-form-item>

    <a-list
        v-if="orderItems?.length"
        style="margin-bottom: 15px;"
        size="small"
        item-layout="horizontal"
        :data-source="orderItems">  
        <template #header>
            <a-typography-text strong>
                Кошик
            </a-typography-text>
        </template>

        <template #renderItem="{ item, index }">
            <a-list-item style="padding: 10px 0;">
                <a-list-item-meta>
                    <template #title>
                        {{ item.name }} x {{ item.quantity }}, {{ formatPrice(item.amount * item.quantity) }}
                    </template>
                </a-list-item-meta>

                <template #actions>
                    <a-flex :gap="5">
                        <a-button 
                            style="width: 25px;" 
                            size="small"
                            @click="item.quantity > 1 && item.quantity--">
                            -
                        </a-button>
                        <a-input
                            style="width: 60px; text-align: center ;"
                            placeholder="К-сть"
                            readonly
                            size="small"
                            v-model:value="item.quantity"/>
                        <a-button 
                            style="width: 25px;" 
                            size="small"
                            @click="item.quantity++">
                            +
                        </a-button>
                    </a-flex>
                    <a-button
                        danger
                        type="text"
                        size="small"
                        @click="removeFromCart(index)">
                        X
                    </a-button>
                </template>
            </a-list-item>
        </template>

        Проміжна сума: 
        <a-typography-text strong>
            {{ formatPrice(subtotal) }}
        </a-typography-text>
    </a-list>
</template>

<script>
import productsApi from '../../../api/products'
import categoriesApi from '../../../api/categories'
import { formatPrice } from '../../../helpers/helpers'

export default {
    props: [
        'orderItems',
        'errors',
    ],
    data() {
        return {
            zaklady: {
                data: [],
                fetching: false,
                selected: null,
            },
            products: {
                data: [],
                fetching: false,
                selected: null,
            },
        }
    },
    computed: {
        zakladOptions() {
            return this.zaklady.data.map(zaklad => {
                return {
                    label: zaklad.name,
                    value: zaklad.id, 
                }
            })
        },
        productOptions() {
            return this.products.data.map(product => {
                let label = product.name
                label += `, ${product.categories.filter(cat => ! cat.parent_id).map(cat => cat.name).join(', ')}`

                return {
                    label: label,
                    value: product.id, 
                }
            })
        },
        subtotal() {
            return this.orderItems.reduce((acc, item) => acc += item.quantity * item.amount, 0)
        },
    },
    methods: {
        formatPrice,
        async fetchZaklady(s) {
            this.zaklady.fetching = true
            const res = await categoriesApi.searchZaklady(s)
            this.zaklady.data = res
            this.zaklady.fetching = false
        },
        async fetchProducts(s) {
            this.products.fetching = true
            const res = await productsApi.search(s, this.zaklady.selected)
            this.products.data = res
            this.products.fetching = false
        },
        addToCart(productId) {
            this.products.data.map(product => {
                if (product.id == productId) {
                    this.orderItems.push({
                        name: product.name,
                        quantity: 1,
                        amount: product.price,
                        product_id: product.id,
                    })
                }
            })
        },
        removeFromCart(i) {
            this.orderItems.splice(i, 1)
        },
    },
}
</script>
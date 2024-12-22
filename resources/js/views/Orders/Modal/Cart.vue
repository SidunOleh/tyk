<template>
    <a-form-item 
        label="Замовлення"
        :required="true"
        has-feedback
        :validate-status="errors['order_items'] ? 'error' : ''"
        :help="errors['order_items']">
        <a-select
            style="width: 100%"
            placeholder="Виберіть товар"
            :filter-option="false"
            :options="productOptions"
            :showSearch="true"
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
                    <a-input-number
                        placeholder="К-сть"
                        size="small"
                        :min="1"
                        v-model:value="item.quantity"/>
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
import { formatPrice } from '../../../helpers/helpers'

export default {
    props: [
        'orderItems',
        'errors',
    ],
    data() {
        return {
            products: {
                data: [],
                fetching: false,
            },
        }
    },
    computed: {
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
        async fetchProducts(s) {
            this.products.fetching = true
            const res = await productsApi.search(s)
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
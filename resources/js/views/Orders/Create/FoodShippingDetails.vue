<template>
    <a-form-item 
        label="Замовлення"
        :required="true"
        has-feedback
        :validate-status="errors['details.order_items'] ? 'error' : ''"
        :help="errors['details.order_items']">
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
        v-if="data.order_items.length"
        style="margin-bottom: 15px;"
        size="small"
        item-layout="horizontal"
        :data-source="data.order_items">  
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

    <a-form-item 
        label="Куди"
        :required="true"
        has-feedback
        :validate-status="errors['details.food_to'] ? 'error' : ''"
        :help="errors['details.food_to']">
        <a-input
            placeholder="Введіть адресу"
            v-model:value="data.food_to"/>
    </a-form-item>
</template>

<script>
import productsApi from '../../../api/products'
import { formatPrice } from '../../../helpers/helpers'

export default {
    props: [
        'details',
        'repeat',
        'errors',
    ],
    data() {
        return {
            data: {
                food_to: '',
                cook_time: null,
                order_items: [],
            },
            products: {
                data: [],
                fetching: false,
            },
        }
    },
    computed: {
        productOptions() {
            return this.products.data.map(product => {
                return {
                    label: `${product.name}`,
                    value: product.id, 
                }
            })
        },
        subtotal() {
            return this.data
                .order_items
                .reduce((acc, item) => acc += item.quantity * item.amount, 0)
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
                    this.data.order_items.push({
                        name: product.name,
                        quantity: 1,
                        amount: product.price,
                        product_id: product.id,
                    })
                }
            })
        },
        removeFromCart(i) {
            this.data.order_items = this.data
                .order_items
                .filter((item, index) => index != i)
        },
    },
    watch: {
        repeat: {
            handler(repeat) {
                this.data.food_to = repeat.details.to

                this.data.order_items = repeat.order_items.map(item => {
                    return {
                        name: item.product.name,
                        quantity: item.quantity,
                        amount: item.product.price,
                        product_id: item.product.id,
                    }
                })
            },
            deep: true,
        },
        data: {
            handler(data) {
                this.$emit('update:details', data)
            },
            deep: true,
        },
    },
    mounted() {
        this.$emit('update:details', this.data)
    },
}
</script>
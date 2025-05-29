<template>
    <a-form-item 
        label="Замовлення"
        :required="true"
        has-feedback
        :validate-status="errors['order_items'] ? 'error' : ''"
        :help="errors['order_items']">
        <a-flex :gap="5">
            <a-tree-select
                style="width: 40%"
                placeholder="Виберіть категорію"
                multiple
                :tree-data="categoryOptions"
                v-model:value="categories.selected"
                @change="fetchProducts('')"/>
            <a-select
                style="width: 60%"
                placeholder="Знайдіть товар"
                :allowClear="true"
                :filter-option="filterProducts"
                :options="productOptions"
                :showSearch="true"
                :showArrow="false"
                v-model:value="products.selected"
                @select="addToCart">
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
                        {{ item.name }} - <b>{{ item.product?.categories?.find(category => category.parent_id === null)?.name }}</b> x {{ item.quantity }}, {{ formatPrice(item.amount * item.quantity) }}
                        <div style="font-size: 12px;">
                            пакування: {{ formatPrice(packagingAmount(item)) }}
                        </div>
                    </template>
                </a-list-item-meta>

                <template #actions>
                    <a-flex :gap="5">
                        <a-button 
                            style="width: 25px;" 
                            size="small"
                            @click="changeQuantity(item, item.quantity-1)">
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
                            @click="changeQuantity(item, item.quantity+1)">
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
    </a-list>

    <a-list
        v-if="zakladAddonAmounts?.length"
        style="margin-bottom: 15px;"
        size="small"
        item-layout="horizontal"
        :data-source="zakladAddonAmounts">  
        <template #header>
            <a-typography-text strong>
                Додаткові суми по закладам
            </a-typography-text>
        </template>

        <template #renderItem="{ item, index }">
            <a-list-item style="padding: 10px 0;">
                <a-list-item-meta>
                    <template #title>
                        <a-flex 
                            :gap="10"
                            :align="'start'">
                            <div style="width: 70%;">{{ getZakladName(item.zaklad_id) ?? '' }}</div>
                            <a-input-number
                                style="width: 30%;"
                                placeholder="Сума"
                                size="small"
                                v-model:value="item.amount"/>
                        </a-flex>
                    </template>
                </a-list-item-meta>
            </a-list-item>
        </template>
    </a-list>

    <div style="margin-bottom: 15px;">
        Проміжна сума:
        <a-typography-text strong>
            {{ formatPrice(subtotal) }}
        </a-typography-text>
    </div>
</template>

<script>
import productsApi from '../../../api/products'
import categoriesApi from '../../../api/categories'
import { formatPrice } from '../../../helpers/helpers'

export default {
    props: [
        'orderItems',
        'zakladAddonAmounts',
        'errors',
    ],
    data() {
        return {
            categories: {
                data: [],
                selected: [],
            },
            products: {
                data: [],
                fetching: false,
                selected: null,
            },
        }
    },
    computed: {
        categoryOptions() {            
            return this.makeCategoryOptions(this.categories.data, null)
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
            return this.orderItems.reduce((acc, item) => acc += item.quantity * item.amount + this.packagingAmount(item), 0) + this.zakladyAddonAmount
        },
        zakladyAddonAmount() {
            return this.zakladAddonAmounts?.reduce((acc, item) => acc += item.amount, 0)
        },
    },
    methods: {
        formatPrice,
        async fetchAllCategories() {
            try {
                const res = await categoriesApi.all() 
                this.categories.data = res.categories
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        makeCategoryOptions(categories, parent) {
            let options = []
            categories.forEach(category => {
                if (category.parent_id === parent) {
                    options.push({
                        label: category.name,
                        value: category.id,
                        children: this.makeCategoryOptions(
                            categories, 
                            category.id
                        )
                    })
                }
            })

            return options
        },
        async fetchProducts(s) {
            this.products.fetching = true
            const res = await productsApi.search(s, this.categories.selected)
            this.products.data = res
            this.products.fetching = false
        },
        filterProducts(input, option) {
            return option.label.match(new RegExp(input, 'i'))
        },
        addToCart(productId) {
            this.products.data.map(product => {
                if (product.id == productId) {
                    this.orderItems.push(this.makeOrderItemFromProduct(product))
                }
            })
        },
        makeOrderItemFromProduct(product) {
            return {
                name: product.name,
                quantity: 1,
                amount: product.price,
                product_id: product.id,
                product: product,
                packaging: product.packaging_products?.map(product => this.makeOrderItemFromProduct(product)) ?? []
            }
        },
        packagingAmount(orderItem) {
            return orderItem.packaging.reduce((acc, item) => acc += item.amount * item.quantity, 0)
        },
        changeQuantity(orderItem, quantity) {
            if (quantity > 0) {
                orderItem.quantity = quantity
                orderItem.packaging.map(item => item.quantity = quantity)
            }
        },
        removeFromCart(i) {
            this.orderItems.splice(i, 1)
        },
        getZakladName(id) {
            for (const orderItem of this.orderItems) {
                for (const category of orderItem?.product?.categories ?? []) {
                    if (category.id == id) {
                        return category.name
                    }
                }
            }

            return null
        },
    },
    mounted() {
        this.fetchAllCategories()
    },
}
</script>
<template>
    <a-form-item 
        label="Тип доставки"
        :required="true"
        has-feedback
        :validate-status="errors['details.shipping_type'] ? 'error' : ''"
        :help="errors['details.shipping_type']">
        <a-select
            style="width: 100%"
            placeholder="Виберіть тип"
            :options="shippingTypeOptions"
            v-model:value="details.shipping_type">
        </a-select>
    </a-form-item>

    <a-form-item 
        label="Звідки"
        :required="true"
        has-feedback
        :validate-status="errors['details.shipping_from'] ? 'error' : ''"
        :help="errors['details.shipping_from']">
        <a-select
            v-model:value="details.shipping_from"
            placeholder="Виберіть адресу"
            :options="fromAddressOptions">
            <template #dropdownRender="{ menuNode: menu }">
                <component :is="menu" />
                <a-divider style="margin: 4px 0" />
                <a-flex 
                    style="padding: 4px 8px"
                    :gap="5">
                    <a-input 
                        v-model:value="newFromAddress" 
                        placeholder="Введіть адресу" />
                    <a-button @click="addFromAddress">
                        <template #icon>
                            <PlusOutlined/>
                        </template>
                        Додати
                    </a-button>
                </a-flex>
            </template>
        </a-select>
    </a-form-item>

    <a-form-item 
        label="Куди"
        :required="true"
        has-feedback
        :validate-status="toErrors.length ? 'error' : ''"
        :help="toErrors">
        <a-select
            v-model:value="details.shipping_to"
            placeholder="Виберіть адресу"
            mode="multiple"
            :options="toAddressOptions">
            <template #dropdownRender="{ menuNode: menu }">
                <component :is="menu" />
                <a-divider style="margin: 4px 0" />
                <a-flex 
                    style="padding: 4px 8px"
                    :gap="5">
                    <a-input 
                        v-model:value="newToAddress" 
                        placeholder="Введіть адресу" />
                    <a-button @click="addToAddress">
                        <template #icon>
                            <PlusOutlined/>
                        </template>
                        Додати
                    </a-button>
                </a-flex>
            </template>
        </a-select>
    </a-form-item>
</template>

<script>
import {
    PlusOutlined,
} from '@ant-design/icons-vue'

export default {
    components: {
        PlusOutlined,
    },
    props: [
        'details',
        'client',
        'errors',
    ],
    data() {
        return {
            fromAddresses: [],
            toAddresses: [],
            newFromAddress: '',
            newToAddress: '',
            shippingTypes: [
                'Посилка з пошти',
                'Посилка з маршрутки',
                'Закуп продуктів',
                'Вручення квітів/подарунків',
                'Забрати замовлення',
                'Набрати води',
                'Набрати бензин',
                'Розвіз зелені',
                'Розвіз хліб',
                'Вантажні перевезення',
                'Тверезий водій',
                'Прикурити авто',
            ],
        }
    },
    computed: {
        fromAddressOptions() {
            return this.fromAddresses.map(address => {
                return {
                    value: address,
                }
            })
        },
        toAddressOptions() {
            return this.toAddresses.map(address => {
                return {
                    value: address,
                }
            })
        },
        shippingTypeOptions() {
            return this.shippingTypes.map(shippingType => {
                return {
                    value: shippingType,
                }
            })
        },
        toErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field.search('shipping_to') >= 0) {
                    errors.push(this.errors[field])
                }
            }

            return errors
        },
    },
    methods: {
        setAddresses() {
            this.fromAddresses = [...this.client?.addresses ?? []]
            if (this.details.shipping_from) {
                this.fromAddresses.push(this.details.shipping_from)
            }
            this.fromAddresses = [...new Set(this.fromAddresses)]

            this.toAddresses = [...this.client?.addresses ?? []]
            this.toAddresses = this.toAddresses.concat(this.details.shipping_to ?? [])
            this.toAddresses = [...new Set(this.toAddresses)]
        },
        addFromAddress() {
            this.fromAddresses.push(this.newFromAddress)
        },
        addToAddress() {
            this.toAddresses.push(this.newToAddress)
        },
    },
    watch: {
        client: {
            handler() {
                this.setAddresses()
            },
            deep: true,
        },
        details: {
            handler() {
                this.setAddresses()
            },
            deep: true,
        },
    },
    mounted() {
        this.details.shipping_from = this.details.shipping_from ? this.details.shipping_from : null
        this.details.shipping_to = this.details.shipping_to ?? []

        this.setAddresses()
    },
}
</script>
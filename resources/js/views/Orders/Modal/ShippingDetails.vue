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
            :options="addressOptions">
            <template #dropdownRender="{ menuNode: menu }">
                <component :is="menu" />
                <a-divider style="margin: 4px 0" />
                <a-flex 
                    style="padding: 4px 8px"
                    :gap="5">
                    <AddressInput v-model:address="newAddress" />
                    <a-button @click="addAddress">
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
            :options="addressOptions">
            <template #dropdownRender="{ menuNode: menu }">
                <component :is="menu" />
                <a-divider style="margin: 4px 0" />
                <a-flex 
                    style="padding: 4px 8px"
                    :gap="5">
                    <AddressInput v-model:address="newAddress" />
                    <a-button @click="addAddress">
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
import AddressInput from '../../components/AddressInput.vue'

export default {
    components: {
        PlusOutlined,
        AddressInput,
    },
    props: [
        'details',
        'client',
        'errors',
    ],
    data() {
        return {
            addresses: [],
            newAddress: '',
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
        addressOptions() {
            return this.addresses.map(address => {
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
                if (field.match(/^details\.shipping_to\.\d$/)) {
                    errors.push(`${this.errors[field]} №${Number(field.split('.').pop())+1}`)
                }

                if (field.match(/^details\.shipping_to$/)) {
                    errors.push(`${this.errors[field]}`)
                }
            }

            return errors
        },
    },
    methods: {
        setAddresses() {
            this.addresses = this.client
                .addresses
                ?.map(address => address.address) ?? []
        },
        addAddress() {
            if (this.newAddress) {
                this.addresses.push(this.newAddress)
                this.newAddress = ''
            }
        },
    },
    watch: {
        client: {
            handler() {
                this.setAddresses()
            },
            deep: true,
        },
    },
    mounted() {
        this.details.shipping_type = this.details.shipping_type 
            ? this.details.shipping_type 
            : null
        this.details.shipping_from = this.details.shipping_from 
            ? this.details.shipping_from
            : null
        this.details.shipping_to = this.details.shipping_to ?? []

        this.setAddresses()
    },
}
</script>
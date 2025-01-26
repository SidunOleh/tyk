<template>
    <a-form-item 
        label="Куди"
        :required="true"
        has-feedback
        :validate-status="toErrors.length ? 'error' : ''"
        :help="toErrors">
        <a-select
            v-model:value="details.food_to"
            placeholder="Виберіть адресу"
            mode="tags"
            :options="addressOptions">
            <template #dropdownRender="{ menuNode: menu }">
                <component :is="menu" />
                <a-divider style="margin: 4px 0" />
                <a-flex 
                    style="padding: 4px 8px"
                    :gap="5">
                    <AddressInput 
                        v-model:address="newAddress"/>
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
        label="Час доставки"
        has-feedback
        :validate-status="errors['details.delivery_time'] ? 'error' : ''"
        :help="errors['details.delivery_time']">
        <a-date-picker
            style="width: 100%;"
            showTime
            v-model:value="details.delivery_time"
            format="YYYY-MM-DD hh:mm"
            valueFormat="YYYY-MM-DD hh:mm:ss"
            placeholder="Виберіть час доставки"/>
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
        toErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field.match(/^details\.food_to\.\d$/)) {
                    errors.push(`${this.errors[field]} №${Number(field.split('.').pop())+1}`)
                }

                if (field.match(/^details\.food_to$/)) {
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
        this.details.food_to = this.details.food_to ?? []
        this.details.delivery_time = this.details.delivery_time 
            ? this.details.delivery_time 
            : ''

        this.setAddresses()
    },
}
</script>
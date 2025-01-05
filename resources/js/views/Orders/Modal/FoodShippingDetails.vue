<template>
    <a-form-item 
        label="Куди"
        :required="true"
        has-feedback
        :validate-status="errors['details.food_to'] ? 'error' : ''"
        :help="errors['details.food_to']">
        <a-select
            v-model:value="details.food_to"
            placeholder="Виберіть адресу"
            :options="addressOptions">
            <template #dropdownRender="{ menuNode: menu }">
                <component :is="menu" />
                <a-divider style="margin: 4px 0" />
                <a-flex 
                    style="padding: 4px 8px"
                    :gap="5">
                    <a-input 
                        v-model:value="newAddress" 
                        placeholder="Введіть адресу" />
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
    },
    methods: {
        setAddresses() {
            this.addresses = [...this.client?.addresses ?? []]
            if (this.details.food_to) {
                this.addresses.push(this.details.food_to)
            }
            this.addresses = [...new Set(this.addresses)]
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
        details: {
            handler() {
                this.setAddresses()
            },
            deep: true,
        },
    },
    mounted() {
        this.details.food_to = this.details.food_to ? this.details.food_to : null

        this.setAddresses()
    },
}
</script>
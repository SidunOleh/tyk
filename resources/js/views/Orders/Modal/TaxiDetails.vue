<template>
    <a-form-item 
        label="Звідки"
        :required="true"
        has-feedback
        :validate-status="errors['details.taxi_from'] ? 'error' : ''"
        :help="errors['details.taxi_from']">
        <a-select
            v-model:value="details.taxi_from"
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
            v-model:value="details.taxi_to"
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
        toErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field.search('taxi_to') >= 0) {
                    errors.push(this.errors[field])
                }
            }

            return errors
        },
    },
    methods: {
        setAddresses() {
            this.fromAddresses = [...this.client?.addresses ?? []]
            if (this.details.taxi_from) {
                this.fromAddresses.push(this.details.taxi_from)
            }
            this.fromAddresses = [...new Set(this.fromAddresses)]

            this.toAddresses = [...this.client?.addresses ?? []]
            this.toAddresses = this.toAddresses.concat(this.details.taxi_to ?? [])
            this.toAddresses = [...new Set(this.toAddresses)]
        },
        addFromAddress() {
            if (this.newFromAddress) {
                this.fromAddresses.push(this.newFromAddress)
                this.newFromAddress = ''
            }
        },
        addToAddress() {
            if (this.newToAddress) {
                this.toAddresses.push(this.newToAddress)
                this.newToAddress = ''
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
        this.details.taxi_from = this.details.taxi_from ? this.details.taxi_from : null
        this.details.taxi_to = this.details.taxi_to ?? []

        this.setAddresses()
    },
}
</script>
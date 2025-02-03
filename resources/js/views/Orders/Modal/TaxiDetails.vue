<template>
    <a-form-item 
        label="Звідки"
        :required="true"
        has-feedback
        :validate-status="fromErrors.length ? 'error' : ''"
        :help="fromErrors">
        <a-select
            v-model:value="from"
            placeholder="Виберіть адресу"
            :options="addressOptions">
            <template #dropdownRender="{ menuNode: menu }">
                <component :is="menu"/>
                <a-divider style="margin: 4px 0"/>
                <a-flex 
                    style="padding: 4px 8px"
                    :gap="5">
                    <AddressInput 
                        v-model:address="address"
                        @placeChanged="address => {addAddress(); from = address.address}"/>
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
            v-model:value="to"
            placeholder="Виберіть адресу"
            mode="multiple"
            :options="addressOptions">
            <template #dropdownRender="{ menuNode: menu }">
                <component :is="menu" />
                <a-divider style="margin: 4px 0" />
                <a-flex 
                    style="padding: 4px 8px"
                    :gap="5">
                    <AddressInput 
                        v-model:address="address"
                        @placeChanged="address => {addAddress(); to.push(address.address)}"/>
                </a-flex>
            </template>
        </a-select>
    </a-form-item>
</template>

<script>
import AddressInput from '../../components/AddressInput.vue'

export default {
    components: {
        AddressInput,
    },
    props: [
        'details',
        'client',
        'errors',
    ],
    data() {
        return {
            from: null,
            to: [],
            addresses: [],
            address: {
                address: '',
                lat: null,
                lng: null,
            },
        }
    },
    computed: {
        addressOptions() {
            return this.addresses.map(address => {
                return {
                    value: address.address,
                }
            })
        },
        fromErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field == 'details.taxi_from') {
                    errors.push(this.errors[field])
                }

                let matches = field.match(/^details\.taxi_from\.(address|lat|lng)$/)
                if (matches) {
                    errors.push(this.errors[field])
                }
            }

            return errors
        },
        toErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field == 'details.taxi_to') {
                    errors.push(this.errors[field])
                }

                let matches = field.match(/^details\.taxi_to\.(\d)\.(address|lat|lng)$/)
                if (matches) {
                    errors.push(`${this.errors[field]} №${Number(matches[1])+1}`)
                }
            }

            return errors
        },
    },
    methods: {
        setAddresses() {
            this.addresses = [
                ...this.client?.addresses ?? [],
                ...this.details.taxi_to
            ]

            if (this.details.taxi_from.address) {
                this.addresses.push(this.details.taxi_from)
            }
        },
        addAddress() {
            this.addresses.push(this.address)

            this.address = {
                address: '',
                lat: null,
                lng: null,
            }
        },
    },
    watch: {
        client: {
            handler(client) {
                this.setAddresses()
            },
            deep: true,
        },
        from(from) {
            this.details.taxi_from = this.addresses.find(address => address.address == from) ?? {
                address: '',
                lat: null,
                lng: null,
            }
        },
        to: {
            handler(to) {
                this.details.taxi_to = to.map(to => {
                    const address = this.addresses.find(address => address.address == to)
                    
                    return {
                        address: to,
                        lat: address?.lat ?? null,
                        lng: address?.lng ?? null,
                    }
                })
            },
            deep: true,
        },
    },
    mounted() {
        this.details.taxi_from = 
            this.details.taxi_from ? this.details.taxi_from : {
                address: '',
                lat: null,
                lng: null,
            }
        this.details.taxi_to = this.details.taxi_to ?? []

        this.setAddresses()

        this.from = this.details.taxi_from.address
        this.to = this.details.taxi_to.map(address => address.address)
    },
}
</script>
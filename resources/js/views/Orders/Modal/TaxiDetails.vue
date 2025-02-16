<template>
    <a-form-item 
        label="Звідки"
        :required="true"
        has-feedback
        :validate-status="fromErrors.length ? 'error' : ''"
        :help="fromErrors">
        <AddressSelect
            :addresses="addresses"
            v-model:value="details.taxi_from"/>
    </a-form-item>

    <a-form-item 
        label="Куди"
        :required="true"
        has-feedback
        :validate-status="toErrors.length ? 'error' : ''"
        :help="toErrors">
        <AddressSelect
            :addresses="addresses"
            :multiple="true"
            v-model:value="details.taxi_to"/>
    </a-form-item>
</template>

<script>
import AddressSelect from '../../components/AddressSelect.vue'

export default {
    components: {
        AddressSelect,
    },
    props: [
        'details',
        'client',
        'errors',
    ],
    data() {
        return {
            addresses: [],
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

                let matches = field.match(/^details\.taxi_from\.address$/)
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

                let matches = field.match(/^details\.taxi_to\.(\d)\.address$/)
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

            const unique = []
            this.addresses.forEach(address => {
                const exists = unique.find((v, i) => v.address == address.address)
                if (exists === undefined) {
                    unique.push(address)
                }
            })
            this.addresses = unique
        },
    },
    watch: {
        client: {
            handler(client) {
                this.setAddresses()
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
    },
}
</script>
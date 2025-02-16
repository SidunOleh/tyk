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
        :validate-status="fromErrors.length ? 'error' : ''"
        :help="fromErrors">
        <AddressSelect
            :addresses="addresses"
            v-model:value="details.shipping_from"/>
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
            v-model:value="details.shipping_to"/>
    </a-form-item>
</template>

<script>
import AddressSelect from '../../components/AddressSelect.vue'
import shippingTypes from '../../../data/courierServices'

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
        shippingTypeOptions() {
            return shippingTypes.map(shippingType => {
                return {
                    value: shippingType,
                }
            })
        },
        fromErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field == 'details.shipping_from') {
                    errors.push(this.errors[field])
                }

                let matches = field.match(/^details\.shipping_from\.address$/)
                if (matches) {
                    errors.push(this.errors[field])
                }
            }

            return errors
        },
        toErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field == 'details.shipping_to') {
                    errors.push(this.errors[field])
                }

                let matches = field.match(/^details\.shipping_to\.(\d)\.address$/)
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
                ...this.details.shipping_to,
            ]

            if (this.details.shipping_from.address) {
                this.addresses.push(this.details.shipping_from)
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
        this.details.shipping_type = 
            this.details.shipping_type ? this.details.shipping_type : null
        this.details.shipping_from = 
            this.details.shipping_from ? this.details.shipping_from : {
                address: '',
                lat: null,
                lng: null,
            }
        this.details.shipping_to = this.details.shipping_to ?? []

        this.setAddresses()
    },
}
</script>
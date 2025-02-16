<template>
    <a-form-item 
        label="Куди"
        :required="true"
        has-feedback
        :validate-status="toErrors.length ? 'error' : ''"
        :help="toErrors">
        <AddressSelect
            :addresses="addresses"
            :multiple="true"
            v-model:value="details.food_to"/>
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
        toErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field == 'details.food_to') {
                    errors.push(this.errors[field])
                }

                let matches = field.match(/^details\.food_to\.(\d)\.address$/)
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
                ...this.details.food_to
            ]

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
        this.details.food_to = 
            this.details.food_to ?? []
        this.details.delivery_time = 
            this.details.delivery_time ? this.details.delivery_time : ''

        this.setAddresses()
    },
}
</script>
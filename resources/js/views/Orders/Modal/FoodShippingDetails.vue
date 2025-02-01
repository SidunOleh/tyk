<template>
    <a-form-item 
        label="Куди"
        :required="true"
        has-feedback
        :validate-status="toErrors.length ? 'error' : ''"
        :help="toErrors">
        <a-select
            v-model:value="to"
            placeholder="Виберіть адресу"
            mode="tags"
            :options="addressOptions">
            <template #dropdownRender="{ menuNode: menu }">
                <component :is="menu"/>
                <a-divider style="margin: 4px 0"/>
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
        toErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field == 'details.food_to') {
                    errors.push(this.errors[field])
                }

                let matches = field.match(/^details\.food_to\.(\d)\.(address|lat|lng)$/)
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
        to: {
            handler(to) {
                this.details.food_to = to.map(to => {
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
        this.details.food_to = 
            this.details.food_to ?? []
        this.details.delivery_time = 
            this.details.delivery_time ? this.details.delivery_time : ''

        this.setAddresses()

        this.to = this.details.food_to.map(address => address.address)
    },
}
</script>
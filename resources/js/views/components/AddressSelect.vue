<template>
    <a-select
        v-model:value="_value"
        placeholder="Виберіть адресу"
        :mode="multiple ? 'multiple' : ''"
        :options="addressOptions"
        @change="updateValue">
        <template #dropdownRender="{ menuNode: menu }">
            <component :is="menu" />
            <a-divider style="margin: 4px 0" />
            <a-flex 
                style="padding: 4px 8px"
                :gap="5">
                <AddressInput 
                    v-model:address="address"
                    @placeChanged="placeChanged"/>
            </a-flex>
        </template>
    </a-select>
</template>

<script>
import AddressInput from './AddressInput.vue'

export default {
    components: {
        AddressInput,
    },
    props: [
        'addresses',
        'value',
        'multiple',
    ],
    data() {
        return {
            _value: null,
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
    },
    methods: {
        placeChanged() {
            this.addresses.push(this.address)

            if (this.multiple) {
                this._value.push(this.address.address)
            } else {
                this._value = this.address.address
            }

            this.updateValue()

            this.address = {
                address: '',
                lat: null,
                lng: null,
            }
        },
        updateValue() {
            let value
            if (this.multiple) {
                value = this._value.map(item => this.addresses.find(address => address.address == item)) ?? []
            } else {
                value = this.addresses.find(address => address.address == this._value)
            }

            this.$emit('update:value', value)
        },
        setSelected() {
            if (this.multiple) {
                this._value = this.value?.map(address => address.address) ?? []
            } else {
                this._value = this.value?.address ?? null
            }
        },
    },
    watch: {
        value: {
            handler(value) {
                this.setSelected()
            },  
            deep: true,
        },
    },
    mounted() {
        this.setSelected()
    },
}
</script>
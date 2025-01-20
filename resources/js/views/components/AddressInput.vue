<template>
    <a-input
        :id="id"
        placeholder="Введіть адресу"
        v-model:value="value"/>
</template>

<script>
export default {
    props: [
        'address',
    ],
    data() {
        return {
            id: this.generateId(),
            value: '',
        }
    },
    methods: {
        generateId() {
            return 'id' + Math.random().toString(16).slice(2)
        },
    },
    watch: {
        address(address) {
            this.value = address
        },
        value(value) {
            this.$emit('update:address', value)
        },
    },
    mounted() {
        this.value = this.address

        const autocomplete = new google.maps.places.Autocomplete(
            document.querySelector(`#${this.id}`), {
                componentRestrictions: {
                    country: 'ua',
                },
            }
        )
        autocomplete.addListener('place_changed', () => {
            this.value = document.querySelector(`#${this.id}`).value
            this.$emit('placeChanged', autocomplete.getPlace())
        })
    },
}
</script>
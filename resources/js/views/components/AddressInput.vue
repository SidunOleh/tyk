<template>
    <a-input
        :id="id"
        placeholder="Введіть адресу"
        v-model:value="address.address"
        @input="() => {address.lat = null; address.lng = null;}"/>
</template>

<script>
export default {
    props: [
        'address',
    ],
    data() {
        return {
            id: this.generateId(),
        }
    },
    methods: {
        generateId() {
            return 'id' + Math.random().toString(16).slice(2)
        },
    },
    mounted() {
        const autocomplete = new google.maps.places.Autocomplete(
            document.querySelector(`#${this.id}`), {
                componentRestrictions: {
                    country: 'ua',
                },
                types: ['geocode'],
            }
        )
        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace()
            this.address.address = document.querySelector(`#${this.id}`).value
            this.address.lat = place.geometry.location.lat()
            this.address.lng = place.geometry.location.lng()
            this.$emit('placeChanged', this.address)
        })
    },
}
</script>
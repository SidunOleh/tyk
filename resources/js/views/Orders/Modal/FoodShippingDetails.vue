<template>
    <a-form-item 
        label="Куди"
        :required="true"
        has-feedback
        :validate-status="errors['details.food_to'] ? 'error' : ''"
        :help="errors['details.food_to']">
        <a-input
            placeholder="Введіть адресу"
            v-model:value="details.food_to"/>
    </a-form-item>
</template>

<script>
export default {
    props: [
        'details',
        'errors',
    ],
    mounted() {
        this.details.food_to = this.details.food_to ?? ''
    },
}
</script>
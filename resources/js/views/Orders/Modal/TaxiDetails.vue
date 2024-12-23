<template>
    <a-form-item 
        label="Звідки"
        :required="true"
        has-feedback
        :validate-status="errors['details.taxi_from'] ? 'error' : ''"
        :help="errors['details.taxi_from']">
        <a-input
            placeholder="Введіть адресу"
            v-model:value="details.taxi_from"/>
    </a-form-item>

    <a-form-item 
        label="Куди"
        :required="true"
        has-feedback
        :validate-status="toErrors.length ? 'error' : ''"
        :help="toErrors">
        <a-flex
            :vertical="true"
            :gap="5">
            <a-flex 
                v-for="(address, i) in details.taxi_to"
                :gap="5"
                :align="'center'">
                <a-input
                    placeholder="Введіть адресу"
                    v-model:value="details.taxi_to[i]"/>
                <a-button
                    danger
                    type="text"
                    size="small"
                    @click="removeToAddress(i)">
                    X
                </a-button>
            </a-flex>

            <a-button
                style="align-self: start;" 
                @click="addToAddress">
                Додати адресу
            </a-button>
        </a-flex>
    </a-form-item>
</template>

<script>
export default {
    props: [
        'details',
        'errors',
    ],
    computed: {
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
        addToAddress() {
            this.details.taxi_to.push('')
        },
        removeToAddress(i) {
            this.details.taxi_to.splice(i, 1)
        },
    },
    mounted() {
        this.details.taxi_from = this.details.taxi_from ?? ''
        this.details.taxi_to = this.details.taxi_to ?? ['']
    },
}
</script>
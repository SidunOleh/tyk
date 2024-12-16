<template>
    <a-form-item 
        label="Звідки"
        :required="true"
        has-feedback
        :validate-status="errors['details.shipping_from'] ? 'error' : ''"
        :help="errors['details.shipping_from']">
        <a-input
            placeholder="Введіть адресу"
            v-model:value="data.shipping_from"/>
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
                v-for="(address, i) in data.shipping_to"
                :gap="5"
                :align="'center'">
                <a-input
                    placeholder="Введіть адресу"
                    v-model:value="data.shipping_to[i]"/>
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
                type="primary"
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
        'repeat',
        'errors',
    ],
    data() {
        return {
            data: {
                shipping_from: '',
                shipping_to: ['',],
            },
        }
    },
    computed: {
        toErrors() {
            const errors = []
            for (const field in this.errors) {
                if (field.search('shipping_to') >= 0) {
                    errors.push(this.errors[field])
                }
            }

            return errors
        },
    },
    methods: {
        addToAddress() {
            this.data.shipping_to.push('')
        },
        removeToAddress(i) {
            this.data.shipping_to = this.data
                .shipping_to
                .filter((address, index) => index != i)
        },
    },
    watch: {
        repeat: {
            handler(repeat) {
                this.data.shipping_from = repeat.details.from
                this.data.shipping_to = repeat.details.to
            },
            deep: true,
        },
        data: {
            handler(data) {
                this.$emit('update:details', data)
            },
            deep: true,
        },
    },
    mounted() {
        this.$emit('update:details', this.data)
    },
}
</script>
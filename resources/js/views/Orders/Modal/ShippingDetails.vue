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
        :validate-status="errors['details.shipping_from'] ? 'error' : ''"
        :help="errors['details.shipping_from']">
        <a-input
            placeholder="Введіть адресу"
            v-model:value="details.shipping_from"/>
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
                v-for="(address, i) in details.shipping_to"
                :gap="5"
                :align="'center'">
                <a-input
                    placeholder="Введіть адресу"
                    v-model:value="details.shipping_to[i]"/>
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
    data() {
        return {
            shippingTypes: [
                'Посилка з пошти',
                'Посилка з маршрутки',
                'Закуп продуктів',
                'Вручення квітів/подарунків',
                'Забрати замовлення',
                'Набрати води',
                'Набрати бензин',
                'Розвіз зелені',
                'Розвіз хліб',
                'Вантажні перевезення',
                'Тверезий водій',
                'Прикурити авто',
            ],
        }
    },
    computed: {
        shippingTypeOptions() {
            return this.shippingTypes.map(shippingType => {
                return {
                    value: shippingType,
                }
            })
        },
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
            this.details.shipping_to.push('')
        },
        removeToAddress(i) {
            this.details.shipping_to.splice(i, 1)
        },
    },
    mounted() {
        this.details.shipping_from = this.details.shipping_from ?? ''
        this.details.shipping_to = this.details.shipping_to ?? ['']
    },
}
</script>
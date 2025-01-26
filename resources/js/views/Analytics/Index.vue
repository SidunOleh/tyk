<template>
    <a-flex 
        style="margin-bottom: 20px;"
        :gap="10"
        :align="'center'">
        <a-range-picker 
            v-model:value="time"
            format="YYYY-MM-DD"
            valueFormat="YYYY-MM-DD"/>

        <a-select
            style="width: 150px;"
            :options="typeOptions"
            v-model:value="type"/>
    </a-flex>

    <div>
        <component 
            :time="time"
            :is="currentComponent"/>
    </div>
</template>

<script>
import Income from './Income.vue'
import Orders from './Orders.vue'
import Products from './Products.vue'

export default {
    components: {
        Income,
        Orders,
        Products,
    },
    data() {
        return {
            time: null,
            type: 'Дохід',
            types: [
                'Дохід',
                'Замовлення',
                'Товари',
            ],
        }
    },
    computed: {
        typeOptions() {
            return this.types.map(type => {
                return {
                    value: type,
                }
            })
        },
        currentComponent() {
            switch (this.type) {
                case 'Дохід':
                    return 'Income'
                case 'Замовлення':
                    return 'Orders'
                case 'Товари':
                    return 'Products'
                case 'Категорії':
                    return 'Categories'
            }
        },
    },
    methods: {
        setTime() {
            const start = new Date()
            start.setDate(1)

            const end = new Date()
            end.setDate(end.getDate())

            const format = d => `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2, 0)}-${String(d.getDate()).padStart(2, 0)}`

            this.time = [
                format(start),
                format(end),
            ]
        },
    },
    mounted() {
        this.setTime()
    },
}
</script>
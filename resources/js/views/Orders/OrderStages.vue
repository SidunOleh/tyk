<template>
    <a-collapse 
        :bordered="false"
        v-model:activeKey="activeKey">
        <a-collapse-panel header="Виконання кур'єром">
            <a-collapse
                v-if="Object.keys(couriersStages).length"
                v-model:activeKey="openCouriers"
                :ghost="true">
                <a-collapse-panel 
                    v-for="(courierStages, key) in couriersStages"
                    :key="key"
                    :header="`${courierStages.courier.first_name} ${courierStages.courier.last_name}`"
                    :showArrow="false">
                    <a-steps
                        size="small"
                        :direction="direction"
                        :current="courierStages.data.length-1"
                        :items="courierStages.data"></a-steps>
                </a-collapse-panel>
            </a-collapse>

            <a-empty v-else/>
        </a-collapse-panel>
    </a-collapse>
</template>

<script>
import { 
    formatDate,
} from '../../helpers/helpers'

export default {
    props: {
        order: {
            type: Object,
        },
        direction: {
            type: String,
            default: 'horizontal',
        },
        open: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            activeKey: this.open ? [0] : [],
            openCouriers: [],
        }
    },
    computed: {
        couriersStages() {
            const stages = {}
            this.order.order_stages.forEach(stage => {
                if (!stage.courier_id) {
                    return
                }
                
                if (! stages[stage.courier_id]) {
                    stages[stage.courier_id] = {
                        courier: stage.courier,
                        data: [],
                    }
                }

                stages[stage.courier_id].data.push({
                    title: stage.stage_value,
                    description: formatDate(stage.created_at),
                })
            })

            return stages
        },
    },
    methods: {
        formatDate,
    },
    mounted() {
        for (const key in this.couriersStages) {
            this.openCouriers.push(key)
        }
    },
}
</script>

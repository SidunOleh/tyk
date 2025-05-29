<template>
    <a-form-item 
        label="Графік роботи"
        has-feedback
        :validate-status="errors['schedule'] ? 'error' : ''"
        :help="errors['schedule']">
            <a-flex 
                :gap="10"
                :vertical="true">
                <template v-for="(day, i) in week">
                    <a-flex 
                        class="schedule-row"
                        :gap="10"
                        :align="'flex-start'">
                        <span style="align-self: center;">{{ day }}</span>
                        <a-form-item 
                            has-feedback
                            :validate-status="errors[`schedule.${i}.start`] ? 'error' : ''"
                            :help="errors[`schedule.${i}.start`]">
                            <a-time-picker
                                style="width: 100%;" 
                                v-model:value="schedule[i].start" 
                                format="HH:mm"
                                value-format="HH:mm"
                                placeholder="Початок"/>
                        </a-form-item>

                        <a-form-item 
                            has-feedback
                            :validate-status="errors[`schedule.${i}.end`] ? 'error' : ''"
                            :help="errors[`schedule.${i}.end`]">
                            <a-time-picker
                                style="width: 100%;" 
                                v-model:value="schedule[i].end" 
                                format="HH:mm"
                                value-format="HH:mm"
                                placeholder="Кінець"/>
                        </a-form-item>
                    </a-flex>
                </template>
            </a-flex>
    </a-form-item>
</template>

<script>
export default {
    props: [
        'value',
        'errors',
    ],
    data() {
        return {
            schedule: [
                {
                    start: null,
                    end: null,
                },
                {
                    start: null,
                    end: null,
                },
                {
                    start: null,
                    end: null,
                },
                {
                    start: null,
                    end: null,
                },
                {
                    start: null,
                    end: null,
                },
                {
                    start: null,
                    end: null,
                },
                {
                    start: null,
                    end: null,
                },
            ],
            week: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Нд',],
        }
    },
    watch: {
        value: {
            handler(value) {
                if (value) {
                    this.schedule = JSON.parse(JSON.stringify(value))
                }
            },
            deep: true,
        },
        schedule: {
            handler(schedule) {
                if (JSON.stringify(schedule) != JSON.stringify(this.value)) {
                    this.$emit('update:value', JSON.parse(JSON.stringify(schedule)))
                }
            },
            deep: true,
        },
    },  
    mounted() {
        if (this.value) {
            this.schedule = JSON.parse(JSON.stringify(this.value))
        }
    },
}
</script>

<style scoped>
.schedule-row > div {
    width: 50% !important;
}

.schedule-row .ant-form-item {
    margin-bottom: 0;
}
</style>
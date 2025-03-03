<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item
                v-if="action == 'open'"
                label="Диспетчер"
                :required="true"
                has-feedback
                :validate-status="errors['dispatcher_id'] ? 'error' : ''"
                :help="errors.dispatcher_id">
                <a-select
                    placeholder="Виберіть диспетчера"
                    :options="dispatcherOptions"
                    v-model:value="data.dispatcher_id"/>
            </a-form-item>

            <a-form-item 
                label="Початок зміни"
                :required="true"
                has-feedback
                :validate-status="errors['start'] ? 'error' : ''"
                :help="errors.start">
                <a-date-picker
                    style="width: 100%;"
                    showTime
                    placeholder="Виберіть час"
                    format="YYYY-MM-DD HH:mm"
                    valueFormat="YYYY-MM-DD HH:mm:ss"
                    v-model:value="data.start"/>
            </a-form-item>

            <a-button
                type="primary"
                :loading="loading"
                @click="action == 'open' ? open() : null">
                Зберегти
            </a-button>

        </a-form>

    </a-modal>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/work-shifts'

export default {
    props: [
        'title',
        'open',
        'action',
        'dispatchers',
        'workShift',
    ],
    data() {
        return {
            data: {
                dispatcher_id: null,
                start: null,
            },
            errors: {},
            loading: false,
        }
    },
    computed: {
        dispatcherOptions() {
            return this.dispatchers.map(dispatcher => {
                return {
                    label: `${dispatcher.first_name} ${dispatcher.last_name}`,
                    value: dispatcher.id,
                }
            })
        },
    },      
    methods: {
        async open() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.openDispatcherWorkShift(
                    this.workShift.id, 
                    this.data
                )
                message.success('Успішно відкрита.')
                this.$emit('open')
                this.$emit('update:open', false)
            } catch (err) {
                if (err?.response?.status == 422) {
                    this.errors = err?.response?.data?.errors
                } else {
                    message.error(err?.response?.data?.message ?? err.message)
                }
            } finally {
                this.loading = false
            }
        },
    },
}
</script>
<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item 
                label="Тариф"
                :required="true"
                has-feedback
                :validate-status="errors['tariff_id'] ? 'error' : ''"
                :help="errors.tariff_id">
                <a-select
                    placeholder="Виберіть тариф"
                    :options="tarrifOptions"
                    v-model:value="data.tariff_id"/>
            </a-form-item>

            <a-flex :gap="10">
                <a-button
                    type="primary"
                    :loading="loading"
                    @click="action == 'create' ? create() : edit()">
                    Зберегти
                </a-button>

                <a-button   
                    v-if="action == 'edit'"
                    danger
                    :loading="deleting"
                    @click="confirmPopup(() => deleteRecord(record), 'Ви впевнені що хочете видалити область?')">
                    Видалити
                </a-button>
            </a-flex>

        </a-form>

    </a-modal>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/regions'
import { confirmPopup } from '../../helpers/helpers'

export default {
    props: [
        'title',
        'open',
        'action',
        'tariffs',
        'points',
        'item',
    ],
    data() {
        return {
            data: {
                points: [],
                tariff_id: null,
            },
            errors: {},
            loading: false,
            deleting: false,
        }
    },   
    computed: {
        tarrifOptions() {
            return this.tariffs.map(tariff => {
                return {
                    label: tariff.name,
                    value: tariff.id,
                }
            })
        },
    },   
    methods: {
        confirmPopup,
        async create() {
            try {
                this.loading = true
                this.errors = {}
                await api.create(this.data)
                message.success('Успішно створено.')
                this.$emit('create')
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
        async edit() {
            try {
                this.loading = true
                this.errors = {}
                await api.edit(this.data.id, this.data)
                message.success('Успішно збережено.')
                this.$emit('edit')
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
        async deleteRecord() {
            try {
                await api.delete(this.data.id)
                message.success('Успішно видалено')
                this.$emit('delete')
                this.$emit('update:open', false)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    mounted() {
        if (this.points) {
            this.data.points = this.points
        }

        if (this.item) {
            this.data = JSON.parse(JSON.stringify(this.item))
            this.data.tariff_id = this.item.tariff.id
        }
    },
}
</script>
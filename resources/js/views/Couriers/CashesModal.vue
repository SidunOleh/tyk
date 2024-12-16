<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-list 
            size="small" 
            bordered 
            :data-source="data"
            :pagination="{pageSize: 5, hideOnSinglePage: true,}">
            <template #renderItem="{ item }">
                <a-list-item>
                    <a-list-item-meta>
                        <template #title>
                            {{ new Date(item.created_at).toLocaleDateString('uk-UA', {day: 'numeric', month: 'long', year:'numeric',}) }}
                        </template>

                        <template #description>
                            <a-flex 
                                style="margin-bottom: 10px;"
                                :gap="5">
                                <a-input-number 
                                    placeholder="Отримано"
                                    :min="0"
                                    v-model:value="item.received" 
                                    prefix="₴" 
                                    style="width: 100%"/>
                                <a-input-number 
                                    placeholder="Повернуто"
                                    :min="0"
                                    v-model:value="item.returned" 
                                    prefix="₴" 
                                    style="width: 100%"/>
                            </a-flex>
                            <a-flex :gap="5">
                                <a-button 
                                    size="small" 
                                    @click="save(item)">
                                    Зберегти
                                </a-button>
                                <a-button 
                                    size="small"
                                    danger
                                    @click="confirmPopup(() => deleteItem(item), 'Ви впевнені що хочете видалити?')">
                                    Видалити
                                </a-button>
                            </a-flex>
                        </template>
                    </a-list-item-meta>
                </a-list-item>
            </template>
        </a-list>

        <a-button 
            style="margin-top: 10px;"
            :loading="loading"
            @click="add">
            Добавити
        </a-button>

    </a-modal>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/cashes'
import { confirmPopup, } from '../../helpers/helpers'

export default {
    props: [
        'open',
        'courier',
    ],
    data() {
        return {
            data: [],
            loading: false,
        }
    },    
    methods: {
        confirmPopup,
        async add() {
            try {
                this.loading = true
                const res = await api.create({
                    created_at: new Date(),
                    received: 0,
                    returned: 0,
                    courier_id: this.courier.id,
                })
                this.data.unshift(res.cash)
                message.success('Успішно додано.')
                this.$emit('edit')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        async save(item) {
            try {
                if (item.id) {
                    await api.edit(item.id, item)
                } else {
                    await api.create(item)
                }

                message.success('Успішно збережено.')
                this.$emit('edit')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async deleteItem(item) {
            try {
                if (item.id) {
                    await api.delete(item.id, item)
                } 

                this.data = this.data.filter(i => i != item)
                message.success('Успішно видалено.')
                this.$emit('edit')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        }
    },
    mounted() {
        this.data = JSON.parse(JSON.stringify(this.courier.cashes))
    },
}
</script>
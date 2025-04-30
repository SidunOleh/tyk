<template>
    <a-spin :spinning="loading">
        <a-list
            item-layout="horizontal"
            bordered
            :data-source="data"
            :locale="{emptyText: 'Немає послуг'}">
            <template #renderItem="{ item }">
                <a-list-item>
                    <a-list-item-meta>
                        <template #title>
                            {{ item.name }}
                        </template>
                    </a-list-item-meta>

                    <template #actions>
                        <a-typography-link @click="edit.item = item; edit.open = true;">
                            редагувати
                        </a-typography-link>
                        <a-typography-link 
                            type="danger"
                            @click="confirmPopup(() => deleteRecord(item), 'Ви впевнені що хочете видалити послугу?')">
                            видалити
                        </a-typography-link>
                    </template>
                </a-list-item>
            </template>
        </a-list>

        <a-button
            style="margin-top: 20px;"
            type="primary"
            @click="create.open = true">
            Створити
        </a-button>
    </a-spin>

    <Modal
        v-if="create.open"
        title="Створити послугу"
        action="create"
        v-model:open="create.open"
        @create="fetch"/>

    <Modal
        v-if="edit.open"
        title="Редагувати послугу"
        action="edit"
        v-model:open="edit.open"
        :item="edit.item"
        @edit="fetch"/>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../api/courier-services'
import { 
    confirmPopup, 
} from '../../helpers/helpers'
import Modal from './Modal.vue'

export default {
    components: {
        Modal,
    },
    data() {
        return {
            data: [],
            create: {
                open: false,
            },
            edit: {
                open: false,
                item: null,
            },
            loading: false,
        }
    },
    methods: {
        confirmPopup,
        async fetch() {
            try {
                this.loading = true
                this.data = await api.all()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        async deleteRecord(item) {
            try {
                this.loading = true
                await api.delete(item.id)
                message.success('Успішно видалено.')
                this.fetch()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
    },
    mounted() {
        this.fetch()
    },  
}
</script>
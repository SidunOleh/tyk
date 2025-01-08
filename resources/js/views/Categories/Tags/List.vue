<template>
    <draggable 
        v-if="tags.length"
        :list="tags"
        @change="reorder">
        <a-flex
            :vertical="true"
            v-for="(tag, i) in tags"
            :key="tag.id">
            <a-spin :spinning="loading == tag.id">
                <a-flex
                    :justify="'space-between'"
                    :gap="5">
                    <a-flex
                        :align="'center'"
                        :gap="10">
                        <span style="border-radius: 5px; overflow: hidden;">
                            <a-image 
                                :src="tag.image"
                                :width="40"
                                :height="40"
                                style="object-fit: cover;"/>
                        </span>
                        {{ tag.name }}
                    </a-flex>
                    <a-flex 
                        :gap="3"
                        :align="'center'">
                        <a-typography-link @click="edit.record = tag; edit.open = true;">
                            Редагувати
                        </a-typography-link>
                        
                        <a-divider type="vertical"/>

                        <a-typography-link 
                            type="danger"
                            @click="confirmPopup(() => deleteRecord(tag), `Ви впевнені що хочете видалити ${tag.name}`)">
                            Видалити
                        </a-typography-link>
                    </a-flex>
                </a-flex>
                <a-divider style="margin: 15px 0;"/>
            </a-spin>
        </a-flex>
    </draggable>
    
    <div 
        v-else
        style="height: 50px;">
        Немає тегів
    </div>

    <FormModal
        v-if="edit.open"
        title="Редагування тега"
        action="edit"
        v-model:open="edit.open"
        :item="edit.record"
        @edit="tag => tags[tags.findIndex(el => el.id == tag.id)] = tag"/>
</template>

<script>
import { message } from 'ant-design-vue'
import { confirmPopup, } from '../../../helpers/helpers'
import api from '../../../api/categories'
import FormModal from './FormModal.vue'
import { VueDraggableNext } from 'vue-draggable-next'

export default {
    props: [
        'tags',
    ],
    components: {
        FormModal,
        draggable: VueDraggableNext,
    },
    data() {
        return {
            edit: {
                open: false,
                record: null,
            },
            loading: null,
        }
    },
    methods: {
        confirmPopup,
        async deleteRecord(tag) {
            try {
                this.loading = tag.id
                await api.deleteTag(tag.id)
                this.tags.splice(this.tags.findIndex(item => item.id == tag.id), 1)
                message.success('Успішно видалено')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = null
            }
        },
        async reorder() {
            try {
                await api.reorderTags({tags: this.tags})
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } 
        },
    },
}
</script>
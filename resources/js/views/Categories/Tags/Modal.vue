<template>
    <a-modal 
        title="Теги"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">
        
        <List :tags="tags"/>

        <a-button   
            type="primary"
            style="margin-top: 15px;"
            @click="create.open = true">
            Додати
        </a-button>

    </a-modal>

    <FormModal
        v-if="create.open"
        action="create"
        title="Створення тега"
        v-model:open="create.open"
        @create="tag => tags.push(tag)"/>
</template>

<script>
import List from './List.vue'
import FormModal from './FormModal.vue'

export default {
    components: {
        List,
        FormModal,
    },
    props: [
        'tags',
        'open',
    ],
    data() {
        return {
            create: {
                open: false,
            },
        }
    },
}
</script>
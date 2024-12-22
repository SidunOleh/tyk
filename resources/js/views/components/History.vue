<template>
    <a-drawer 
        title="Історія"
        :open="open"
        @close="$emit('update:open', false)">
        <a-timeline>
            <a-timeline-item v-for="item in history">
                {{ `${item.action} ${formatDate(item.date)} користувачем ${item.user}` }}

                <a-flex
                    v-if="Object.keys(item.data).length != 0"
                    style="margin-top: 5px;"
                    :gap="5"
                    :justify="'space-between'">
                    <a-typography-text strong>
                        Детальніше
                    </a-typography-text>
                    <a-typography-link 
                        v-if="item.show"
                        @click="item.show = false">
                        Приховати
                    </a-typography-link>
                    <a-typography-link
                        v-if="! item.show"
                        @click="item.show = true">
                        Показати
                    </a-typography-link>
                </a-flex>

                <a-descriptions
                    v-if="item.show" 
                    size="small"
                    :column="1">
                    <a-descriptions-item 
                        v-for="(value, name) in item.data"
                        :label="name">
                        {{ value }}
                    </a-descriptions-item>
                </a-descriptions>
            </a-timeline-item>
        </a-timeline>
    </a-drawer>
</template>

<script>
import { formatDate, } from '../../helpers/helpers'

export default {
    props: [
        'history',
        'open',
    ],
    methods: {
        formatDate,
    },
}
</script>
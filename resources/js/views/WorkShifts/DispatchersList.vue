<template>
    <a-list
        item-layout="horizontal"
        bordered
        :data-source="dispatchers"
        :locale="{emptyText: 'Немає диспетчерів'}">
        <template #renderItem="{ item }">
            <a-list-item>
                <a-list-item-meta>
                    <template #title>
                        {{ `${item.dispatcher.first_name} ${item.dispatcher.last_name}` }}
                        <a-typography-text type="secondary">
                            {{ formatDate(item.start) }} - {{ item.end ? formatDate(item.end) : 'працює' }}
                        </a-typography-text>
                    </template>
                </a-list-item-meta>

                <template 
                    v-if="item.status == 'open'"
                    #actions>
                    <a-typography-link 
                        type="danger"
                        @click="$emit('close', item)">
                        закрити
                    </a-typography-link>
                </template>
            </a-list-item>
        </template>
    </a-list>
</template>

<script>
import { 
    formatDate,
} from '../../helpers/helpers'

export default {
    props: [
        'dispatchers',
    ],
    methods: {
        formatDate,
    },
}
</script>
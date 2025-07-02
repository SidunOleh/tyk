<template>
    <a-list
        item-layout="horizontal"
        bordered
        :data-source="drivers"
        :locale="{emptyText: 'Немає водіїв'}">
        <template #renderItem="{ item }">
            <a-list-item>
                <a-list-item-meta>
                    <template #title>
                        {{ `${item.courier.first_name} ${item.courier.last_name}` }}
                        <a-typography-text type="secondary">
                            {{ formatDate(item.start) }} - {{ item.end ? formatDate(item.end) : (item.approximate_end ? `працює до ${formatDate(item.approximate_end)}` : 'працює') }}
                        </a-typography-text>
                    </template>
                </a-list-item-meta>

                <template 
                    v-if="item.status == 'open'"
                    #actions>
                    <a-typography-link  @click="$emit('edit', item)">
                        редагувати
                    </a-typography-link>
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
        'drivers',
    ],
    methods: {
        formatDate,
    },
}
</script>
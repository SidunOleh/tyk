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
export default {
    props: [
        'drivers',
    ]
}
</script>
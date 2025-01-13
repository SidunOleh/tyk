<template>
    <draggable 
        class="dragArea" 
        tag="div" 
        :group="{name: 'g1'}"
        :list="list">
        <div 
            v-for="(el, i) in list" 
            :key="el.name"
            @click.stop="el.showSublist = ! el.showSublist">
            <a-flex 
                :align="'center'"
                :justify="'space-between'"
                :gap="5">
                <a-typography-title
                    class="name"
                    :level="4">
                    {{ el.name }}
                </a-typography-title>

                <router-link 
                    style="font-size: 15px;" 
                    :to="{name: 'sort.products', params: {id: el.id}}">
                    товари
                </router-link>
            </a-flex>
            <category-list 
                v-if="el.showSublist"
                :list="el.children"
                @change="e => $emit('change', e)"/>
        </div>
    </draggable>
</template>

<script>
import { VueDraggableNext } from 'vue-draggable-next'
  
export default {
    name: 'category-list',
    components: {
        draggable: VueDraggableNext,
    },
    props: {
        list: {
            required: true,
            type: Array,
        },
    },
  }
</script>

<style scoped>
.dragArea {
    min-height: 50px;
    padding: 10px;
    outline: 2px dashed;
    margin: 10px 0;
}

.dragArea div .name {
    margin-bottom: 10px;
    cursor: pointer;
}

.dragArea > div:last-child > div > .name {
    margin-bottom: 0;
}
</style>
<template>

    <div :class="'items'">

        <div
            v-for="(item, i) in items" 
            class="item">

            <a-flex 
                align="center"
                :gap="10">

                <a-flex :vertical="true">   
                    <a-tooltip>
                        <template #title>
                            Вверх
                        </template>
            
                        <div 
                            style="cursor: pointer; font-size: 14px;"
                            @click="moveUp(items, i)">
                            ↑
                        </div>
                    </a-tooltip>     

                    <a-tooltip placement="bottom">
                        <template #title>
                            Вниз
                        </template>
            
                        <div 
                            style="cursor: pointer; font-size: 14px;"
                            @click="moveDown(items, i)">
                            ↓
                        </div>
                    </a-tooltip>     
                </a-flex>

                <a-flex
                    style="flex-grow: 1;" 
                    :vertical="true"
                    :gap="10">

                    <a-form-item label="Сервіс">
                        <a-select
                            placeholder="Сервіс"
                            :options="courierServiceOptions"
                            v-model:value="item.service">
                        </a-select>
                    </a-form-item>

                    <a-form-item label="Іконка">
                        <Upload v-model:uploaded="item.icon"/>
                    </a-form-item>

                    <a-form-item label="Заголовок">
                        <a-input
                            placeholder="Заголовок" 
                            v-model:value="item.title"/>
                    </a-form-item>

                    <a-form-item label="Підзаголовок">
                        <a-input
                            placeholder="Підзаголовок" 
                            v-model:value="item.subtitle"/>
                    </a-form-item>

                    <a-form-item label="Зображення">
                        <Upload v-model:uploaded="item.img"/>
                    </a-form-item>
                        
                </a-flex>

                <a-tooltip>
                    <template #title>
                        Видалити
                    </template>
        
                    <div 
                        style="cursor: pointer;"
                        @click="items.splice(i, 1)">
                        х
                    </div>
                </a-tooltip>

            </a-flex>

            <a-divider/>

        </div>

        <a-button
            style="margin-left: 18px;"  
            @click="items.push({service: null, icon: null, title: '', subtitle: '', img: null,})">
            Додати
        </a-button>

    </div>

</template>

<script>
import Upload from '../components/Upload.vue'
import courierServices from '../../data/courierServices'

export default {
    components: {
        Upload,
    },
    props: [
        'items', 
    ],
    computed: {
        courierServiceOptions() {
            return courierServices.map(service => {
                return {
                    label: service,
                    value: service,
                }
            })
        },
    },
    methods: {
        moveUp(items, i) {
            if (i == 0) {
                return
            }

            const el = items[i]
            items[i] = items[i-1]
            items[i-1] = el
        },
        moveDown(items, i) {
            if (items.length-1 == i) {
                return
            }

            const el = items[i]
            items[i] = items[i+1]
            items[i+1] = el
        },
    }
}
</script>

<style scoped>
.items {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #d9d9d9;
}

.item {
    margin: 10px 0px;
}

.ant-a-input {
    margin-bottom: 5px;
}
</style>
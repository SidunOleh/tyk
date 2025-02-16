<template>
    <a-layout style="min-height: 100vh;">
        <a-layout-sider 
            theme='light'
            v-model:collapsed="collapsed"
            collapsible>

            <a-menu 
                v-model:selectedKeys="selectedKeys" 
                mode="inline">
                <a-menu-item key="dashboard">
                    <template #icon>
                        <DashboardOutlined/>
                    </template>
                    <router-link :to="{name: 'dashboard'}">
                        Дашборд
                    </router-link>
                </a-menu-item>

                <a-menu-item key="orders">
                    <template #icon>
                        <ShoppingCartOutlined/>
                    </template>
                    <router-link :to="{name: 'orders.index'}">
                        Замовлення
                    </router-link>
                </a-menu-item>

                <a-menu-item key="clients">
                    <template #icon>
                        <TeamOutlined/>
                    </template>
                    <router-link :to="{name: 'clients.index'}">
                        Клієнти
                    </router-link>
                </a-menu-item>

                <a-menu-item key="couriers">
                    <template #icon>
                        <DragOutlined/>
                    </template>
                    <router-link :to="{name: 'couriers.index'}">
                        Кур'єри
                    </router-link>
                </a-menu-item>

                <a-menu-item key="cars">
                    <template #icon>
                        <CarOutlined/>
                    </template>
                    <router-link :to="{name: 'cars.index'}">
                        Автомобілі
                    </router-link>
                </a-menu-item>

                <a-sub-menu>
                    <template #icon>
                        <CreditCardOutlined/>
                    </template>
                    <template #title>
                        Тарифи
                    </template>

                    <a-menu-item key="tariffs">
                        <router-link :to="{name: 'tariffs.index'}">
                            Тарифи
                        </router-link>
                    </a-menu-item>

                    <a-menu-item key="regions">
                        <router-link :to="{name: 'regions.index'}">
                            Області
                        </router-link>
                    </a-menu-item>

                    <a-menu-item key="price.settings">
                        <router-link :to="{name: 'price.settings'}">
                            Ціни
                        </router-link>
                    </a-menu-item>
                </a-sub-menu>

                <a-sub-menu>
                    <template #icon>
                        <ShopOutlined/>
                    </template>
                    <template #title>
                        Магазин
                    </template>

                    <a-menu-item key="products">
                        <router-link :to="{name: 'products.index'}">
                            Товари
                        </router-link>
                    </a-menu-item>

                    <a-menu-item key="categories">
                        <router-link :to="{name: 'categories.index'}">
                            Категорії
                        </router-link>
                    </a-menu-item>

                    <a-menu-item key="sort">
                        <router-link :to="{name: 'sort.categories'}">
                            Порядок
                        </router-link>
                    </a-menu-item>
                </a-sub-menu>

                <a-menu-item key="promotions">
                    <template #icon>
                        <SoundOutlined />
                    </template>
                    <router-link :to="{name: 'promotions.index'}">
                        Акції
                    </router-link>
                </a-menu-item>

                <a-menu-item key="analytics">
                    <template #icon>
                        <LineChartOutlined />
                    </template>
                    <router-link :to="{name: 'analytics.index'}">
                        Аналітика
                    </router-link>
                </a-menu-item>

                <a-menu-item key="content">
                    <template #icon>
                        <EditOutlined/>
                    </template>
                    <router-link :to="{name: 'content.index'}">
                        Контент
                    </router-link>
                </a-menu-item>

                <a-menu-item key="users">
                    <template #icon>
                        <UserOutlined/>
                    </template>
                    <router-link :to="{name: 'users.index'}">
                        Користувачі
                    </router-link>
                </a-menu-item>

            </a-menu>
            
            <Logout :collapsed="collapsed"/>

        </a-layout-sider>

        <a-layout-content class="content" :style="{margin: '24px 16px', padding: '24px', background: '#fff',  'border-radius': '5px',}">
            <slot></slot>

            <!-- <a-float-button 
                type="primary"
                @click="order.create = true">
                <template #icon>
                    <PlusOutlined />
                </template>

                <template #tooltip>
                    Створити замовлення
                </template>
            </a-float-button> -->
        </a-layout-content>
    </a-layout>

    <OrderModal
        v-if="order.create"
        title="Створення замовлення"
        action="create"
        :client="order.client"
        v-model:open="order.create"/>
</template>

<script>
import {
  UserOutlined,
  MenuUnfoldOutlined,
  MenuFoldOutlined,
  DashboardOutlined,
  ShoppingCartOutlined,
  ShopOutlined,
  PlusOutlined,
  UserAddOutlined,
  CarOutlined,
  TeamOutlined,
  SoundOutlined,
  DragOutlined,
  LineChartOutlined,
  PhoneOutlined,
  EditOutlined,
  SettingOutlined,
  CreditCardOutlined,
} from '@ant-design/icons-vue'
import Logout from './Logout.vue'
import OrderModal from '../Orders/Modal/Modal.vue'
import { auth } from '../../helpers/helpers'
import Phonet from '../../helpers/phonet'
import clientsApi from '../../api/clients'
import { 
    message,
    notification, 
    Button,
} from 'ant-design-vue'
import { h } from 'vue'

export default {
    components: {
        UserOutlined,
        MenuUnfoldOutlined,
        MenuFoldOutlined,
        DashboardOutlined,
        Logout,
        ShoppingCartOutlined,
        ShopOutlined,
        PlusOutlined,
        UserAddOutlined,
        CarOutlined,
        TeamOutlined,
        OrderModal,
        SoundOutlined,
        DragOutlined,
        LineChartOutlined,
        EditOutlined,
        SettingOutlined,
        CreditCardOutlined,
    },
    data() {
        return {
            selectedKeys: [],
            collapsed: true,
            order: {
                create: false,
                client: null,
            },
            caller: null,
        }
    },
    methods: {
        auth,
        async handleCall(call) {
            if (this.caller === call.otherLegs[0].num) {
                return
            }

            this.caller = call.otherLegs[0].num

            const client = {}
            const phone = call.otherLegs[0].num
            client.phone = `(${phone[3] + phone[4] + phone[5]}) ${phone[6] + phone[7] + phone[8]}-${phone[9] + phone[10]}-${phone[11] + phone[12]}`
            client.full_name = call.otherLegs[0].name

            const res = await clientsApi.findOrCreate(client)

            if (! this.order.create) {
                this.order.create = true
                this.order.client = res.client
                return
            }

            const key = Date.now()

            notification.open({
                message: `Дзвінок від ${res.client.full_name}, ${res.client.phone}`,
                duration: 0,
                key,
                icon: () => h(
                    PhoneOutlined, 
                    { 
                        style: 'color: #108ee9' 
                    }
                ),
                btn: () => h(
                    Button,
                    {
                        type: 'primary',
                        size: 'small',
                        onClick: () => {
                            notification.close(key)
                            this.order.create = false
                            setTimeout(() => {
                                this.order.create = true
                                this.order.client = res.client
                            })
                        }
                    },
                    { 
                        default: () => 'Відкрити',
                    },
                ),
            })
        },
    },
    handleHangup(call) {
        this.caller = null
    },
    async mounted() {
        await this.$router.isReady()

        this.selectedKeys.push(this.$router.currentRoute.value.meta.key)

        if (typeof phonetConf !== 'undefined') {
            const phonet = new Phonet(phonetConf)

            phonet.listen('call.bridge', this.handleCall)
            phonet.listen('call.hangup', this.handleHangup)
        }
    },
}
</script>

<template>
    <a-layout style="min-height: 100vh;">
        <a-layout-sider 
            theme='light'
            v-model:collapsed="collapsed"
            collapsible>

            <a-menu 
                v-model:selectedKeys="selectedKeys" 
                mode="inline">
                <a-menu-item 
                    v-if="hasRole(['адмін', 'диспетчер'])"
                    key="dashboard">
                    <template #icon>
                        <DashboardOutlined/>
                    </template>
                    <router-link :to="{name: 'dashboard'}">
                        Дашборд
                    </router-link>
                </a-menu-item>

                <a-sub-menu v-if="hasRole(['адмін', 'диспетчер'])">
                    <template #icon>
                        <ClockCircleOutlined/>
                    </template>
                    <template #title>
                        Зміна
                    </template>

                    <a-menu-item key="work-shifts.current">
                        <router-link :to="{name: 'work-shifts.current'}">
                            Зміна
                        </router-link>
                    </a-menu-item>

                    <a-menu-item key="work-drifts.index">
                        <router-link :to="{name: 'work-shifts.index'}">
                            Архів
                        </router-link>
                    </a-menu-item>
                </a-sub-menu>

                <a-menu-item 
                    v-if="hasRole(['адмін', 'диспетчер'])"
                    key="orders">
                    <template #icon>
                        <ShoppingCartOutlined/>
                    </template>
                    <router-link :to="{name: 'orders.index'}">
                        Замовлення
                    </router-link>
                </a-menu-item>

                <a-menu-item 
                    v-if="hasRole(['адмін', 'диспетчер'])"
                    key="clients">
                    <template #icon>
                        <TeamOutlined/>
                    </template>
                    <router-link :to="{name: 'clients.index'}">
                        Клієнти
                    </router-link>
                </a-menu-item>

                <a-menu-item 
                    v-if="hasRole(['адмін', 'диспетчер'])"
                    key="couriers">
                    <template #icon>
                        <DragOutlined/>
                    </template>
                    <router-link :to="{name: 'couriers.index'}">
                        Кур'єри
                    </router-link>
                </a-menu-item>

                <a-menu-item 
                    v-if="hasRole(['адмін', 'диспетчер'])"
                    key="cars">
                    <template #icon>
                        <CarOutlined/>
                    </template>
                    <router-link :to="{name: 'cars.index'}">
                        Автомобілі
                    </router-link>
                </a-menu-item>

                <a-sub-menu v-if="hasRole(['адмін',])">
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

                <a-sub-menu v-if="hasRole(['адмін', 'диспетчер'])">
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

                <a-menu-item 
                    v-if="hasRole(['адмін', 'диспетчер'])"
                    key="promotions">
                    <template #icon>
                        <SoundOutlined />
                    </template>
                    <router-link :to="{name: 'promotions.index'}">
                        Акції
                    </router-link>
                </a-menu-item>

                <a-menu-item 
                    v-if="hasRole(['адмін',])"
                    key="analytics">
                    <template #icon>
                        <LineChartOutlined />
                    </template>
                    <router-link :to="{name: 'analytics.index'}">
                        Аналітика
                    </router-link>
                </a-menu-item>

                <a-menu-item 
                    v-if="hasRole(['адмін', 'диспетчер'])"
                    key="content">
                    <template #icon>
                        <EditOutlined/>
                    </template>
                    <router-link :to="{name: 'content.index'}">
                        Контент
                    </router-link>
                </a-menu-item>

                <a-menu-item 
                    v-if="hasRole(['адмін',])"
                    key="users">
                    <template #icon>
                        <UserOutlined/>
                    </template>
                    <router-link :to="{name: 'users.index'}">
                        Користувачі
                    </router-link>
                </a-menu-item>

                <a-menu-item 
                    v-if="hasRole(['адмін',])"
                    key="settings">
                    <template #icon>
                        <SettingOutlined/>
                    </template>
                    <router-link :to="{name: 'settings.index'}">
                        Налаштування
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
  ClockCircleOutlined,
} from '@ant-design/icons-vue'
import Logout from './Logout.vue'
import OrderModal from '../Orders/Modal/Modal.vue'
import { 
    auth,
    hasRole,
} from '../../helpers/helpers'
import Phonet from '../../helpers/phonet'
import clientsApi from '../../api/clients'
import { 
    message,
    notification, 
    Button,
} from 'ant-design-vue'
import { h } from 'vue'
import workShiftsApi from '../../api/work-shifts'

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
        ClockCircleOutlined,
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
        hasRole,
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
        handleHangup(call) {
            this.caller = null
        },
        showWorkShiftNotification() {
            const key = Date.now()

            notification.open({
                message: 'Немає відкритої зміни',
                duration: 0,
                key,
                placement: 'top',
                btn: () => h(
                    Button,
                    {
                        type: 'primary',
                        size: 'small',
                        onClick: async () => {
                            try {
                                await workShiftsApi.open()
                                notification.close(key)
                                if (this.$route.name == 'work-shifts.current') {
                                    location.reload()
                                } else {
                                    this.$router.push({name: 'work-shifts.current'})
                                }
                                hasOpenWorkShift = true
                            } catch (err) {
                                message.error(err?.response?.data?.message ?? err.message)
                            }
                        }
                    },
                    { 
                        default: () => 'Відкрити',
                    },
                ),
            })
        },
    },
    async mounted() {
        await this.$router.isReady()

        this.selectedKeys.push(this.$router.currentRoute.value.meta.key)

        if (typeof phonetConf !== 'undefined') {
            const phonet = new Phonet(phonetConf)

            phonet.listen('call.bridge', this.handleCall)
            phonet.listen('call.hangup', this.handleHangup)
        }

        if (
            ! hasOpenWorkShift
            && hasRole(['адмін', 'диспетчер',])
        ) {
            this.showWorkShiftNotification()
        }
    },
}
</script>

<template>
    <a-layout style="min-height: 100vh;">
        <a-layout-sider 
            theme='light'
            v-model:collapsed="collapsed"
            collapsible>

            <Logout :collapsed="collapsed"/>
            
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

                <a-menu-item key="clients">
                    <template #icon>
                        <WalletOutlined/>
                    </template>
                    <router-link :to="{name: 'clients.index'}">
                        Клієнти
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
                </a-sub-menu>

                <a-menu-item key="couriers">
                    <template #icon>
                        <CarOutlined/>
                    </template>
                    <router-link :to="{name: 'couriers.index'}">
                        Кур'єри
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
        </a-layout-sider>

        <a-layout-content class="content" :style="{margin: '24px 16px', padding: '24px', background: '#fff',  'border-radius': '5px',}">
            <slot></slot>

            <a-float-button 
                type="primary"
                @click="order.create = true">
                <template #icon>
                    <PlusOutlined />
                </template>

                <template #tooltip>
                    Створити замовлення
                </template>
            </a-float-button>
        </a-layout-content>
    </a-layout>

    <OrderModal
        v-if="order.create"
        title="Створення замовлення"
        action="create"
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
  WalletOutlined,
} from '@ant-design/icons-vue'
import Logout from './Logout.vue'
import OrderModal from '../Orders/Modal/Modal.vue'

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
        WalletOutlined,
        OrderModal,
    },
    data() {
        return {
            selectedKeys: [],
            collapsed: true,
            order: {
                create: false,
            },
        }
    },
    async mounted() {
        await this.$router.isReady()

        this.selectedKeys.push(this.$router.currentRoute.value.meta.key)
    },
}
</script>

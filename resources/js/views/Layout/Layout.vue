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

                <a-menu-item key="couriers">
                    <template #icon>
                        <ShoppingCartOutlined/>
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
            <div class="content-wrapper">
                <slot></slot>
            </div>
        </a-layout-content>
    </a-layout>
</template>

<script>
import {
  UserOutlined,
  MenuUnfoldOutlined,
  MenuFoldOutlined,
  DashboardOutlined,
  ShoppingCartOutlined,
} from '@ant-design/icons-vue'
import Logout from './Logout.vue'

export default {
    components: {
        UserOutlined,
        MenuUnfoldOutlined,
        MenuFoldOutlined,
        DashboardOutlined,
        Logout,
        ShoppingCartOutlined,
    },
    data() {
        return {
            selectedKeys: [],
            collapsed: true,
        }
    },
    async mounted() {
        await this.$router.isReady()

        this.selectedKeys.push(this.$router.currentRoute.value.meta.key)
    },
}
</script>

<style scoped>
.content-wrapper {
    background: #f5f5f5;
    padding: 20px;
    border-radius: 5px;
}
</style>

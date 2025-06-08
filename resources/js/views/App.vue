<template>
    <a-locale-provider :locale="locale">
        <component :is="layout">
            <router-view/>
        </component>
    </a-locale-provider>
</template>

<script>
import Layout from './Layout/Layout.vue'
import AuthLayout from './Layout/AuthLayout.vue'
import ukUa from 'ant-design-vue/lib/locale/uk_UA'
import { hasRole } from '../helpers/helpers'
import DriverLayout from './Layout/DriverLayout.vue'

export default {
    components: {
        Layout, AuthLayout, DriverLayout,
    },
    data() {
        return {
            locale: ukUa,
        }
    },
    computed: {
        layout() {
            switch (this.$route.name) {
                case 'login':
                    return 'AuthLayout'  
                case 'password.forgot':
                    return 'AuthLayout'  
                case 'password.reset':
                    return 'AuthLayout'  
                default:
                    return hasRole(['кур\'єр']) ? 'DriverLayout' : 'Layout'
            }
        }
    }
}
</script>
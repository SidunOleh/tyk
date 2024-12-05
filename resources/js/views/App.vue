<template>
    <component :is="layout">
        <router-view/>
    </component>
</template>

<script>
import Layout from './Layout/Layout.vue'
import AuthLayout from './Layout/AuthLayout.vue'

export default {
    components: {
        Layout, AuthLayout,
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
                    return 'Layout'
            }
        }
    }
}
</script>
import { createRouter, createWebHistory, } from 'vue-router'
import { auth, hasRole, } from '../helpers/helpers'
import { defineAsyncComponent } from 'vue'
import Loader from '../views/components/Loader.vue'
import { message } from 'ant-design-vue'

const routes = [{
    path: '/login',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Login.vue'),
        loadingComponent: Loader,
    }),
    name: 'login',
    meta: {
        public: true,
        title: 'Вхід',
    },
}, {
    path: '/forgot-password',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/ForgotPassword.vue'),
        loadingComponent: Loader,
    }),
    name: 'password.forgot',
    meta: {
        public: true,
        title: 'Забув пароль',
    },
}, {
    path: '/reset-password',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/ResetPassword.vue'),
        loadingComponent: Loader,
    }),
    name: 'password.reset',
    meta: {
        public: true,
        title: 'Змінити пароль',
    },
}, {
    path: '/',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Dashboard/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'dashboard',
    meta: {
        key: 'dashboard',
        title: 'Дашборд',
    }
}, {
    path: '/users',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Users/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'users.index',
    meta: {
        roles: ['адмін', ],
        key: 'users',
        title: 'Користувачі',
    },
}, {
    path: '/couriers',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Couriers/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'couriers.index',
    meta: {
        roles: ['адмін', ],
        key: 'couriers',
        title: 'Кур\'єри',
    },
}, {
    path: '/products',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Products/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'products.index',
    meta: {
        roles: ['адмін', ],
        key: 'products',
        title: 'Товари',
    },
}, {
    path: '/categories',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Categories/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'categories.index',
    meta: {
        roles: ['адмін', ],
        key: 'categories',
        title: 'Категорії',
    },
}, {
    path: '/:pathMatch(.*)*',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Errors/404.vue'),
        loadingComponent: Loader,
    }),
    name: '404',
    meta: {
        title: '404',
    },
}, ]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from) => {
    document.title = `${to.meta.title} | Адмін Панель`

    if (!to.meta.public && !auth.isLogged()) {
        router.push({ name: 'login' })
        return false
    }

    if (to.meta.roles && !hasRole(to.meta.roles)) {
        message.error('Заборонено.')
        return false
    }
})

export default router
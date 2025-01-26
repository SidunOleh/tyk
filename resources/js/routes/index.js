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
    path: '/clients',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Clients/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'clients.index',
    meta: {
        roles: ['адмін', ],
        key: 'clients',
        title: 'Клієнти',
    },
}, {
    path: '/orders',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Orders/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'orders.index',
    meta: {
        roles: ['адмін', ],
        key: 'orders',
        title: 'Замовлення',
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
    path: '/sort/categories',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Sort/Categories.vue'),
        loadingComponent: Loader,
    }),
    name: 'sort.categories',
    meta: {
        roles: ['адмін', ],
        key: 'sort',
        title: 'Сортування категорій',
    },
}, {
    path: '/sort/categories/:id/products',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Sort/Products.vue'),
        loadingComponent: Loader,
    }),
    name: 'sort.products',
    meta: {
        roles: ['адмін', ],
        key: 'sort',
        title: 'Сортування товарів',
    },
}, {
    path: '/promotions',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Promotions/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'promotions.index',
    meta: {
        roles: ['адмін', ],
        key: 'promotions',
        title: 'Акції',
    },
}, {
    path: '/cars',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Cars/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'cars.index',
    meta: {
        roles: ['адмін', ],
        key: 'cars',
        title: 'Автомобілі',
    },
}, {
    path: '/analytics',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Analytics/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'analytics.index',
    meta: {
        roles: ['адмін', ],
        key: 'analytics',
        title: 'Аналітика',
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
    document.title = `${to.meta.title} - CRM`

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
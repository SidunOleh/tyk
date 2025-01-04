import authApi from '../api/auth'
import { Modal } from 'ant-design-vue'

const auth = {
    async login(credentials) {
        await axios.get('/sanctum/csrf-cookie')
        
        const data = await authApi.login(credentials)

        localStorage.setItem('auth', JSON.stringify({
            user: data,
        }))
    },
    async logout() {
        await authApi.logout()

        this.logoutOnClient()
    },
    logoutOnClient() {
        localStorage.removeItem('auth')
    },
    isLogged() {
        const auth = JSON.parse(localStorage.getItem('auth'))

        return Boolean(auth)
    },
    user() {
        const auth = JSON.parse(localStorage.getItem('auth'))

        return auth?.user
    },
}

const hasRole = roles => {
    const user = auth.user()

    if (roles.includes(user?.role)) {
        return true
    }

    return false
}

function confirmPopup(callback, title) {
    Modal.confirm({
        title: title ?? 'Ви впевнені?',
        okText: 'Так',
        cancelText: 'Ні',
        onOk: callback,
    })
}

function successPopup(title) {
    Modal.success({
        title: title ?? 'Успішно.',
    })
}

function warningPopup(title) {
    Modal.warning({
        title: title ?? 'Успішно.',
    })
}

function errorPopup(error) {
    Modal.error({
        title: error ?? 'Помилка.',
    })
}

function formatPrice(price) {
    return new Intl.NumberFormat('uk-UA', {
        style: 'currency',
        currency: 'UAH',
        trailingZeroDisplay: 'stripIfInteger'
    }).format(price)
}

function formatDate(date, withTime = true) {
    const options = {
        year: 'numeric', 
        month: 'long', 
        day: 'numeric', 
    }

    if (withTime) {
        options.hour = '2-digit'
        options.minute = '2-digit'
    }

    return new Date(date).toLocaleString('uk-UA', options)
}

function serviceColor(service) {
    switch (service) {
        case 'Доставка їжі':
            return 'orange'
        case 'Кур\'єр':
            return 'pink'
        case 'Таксі':
            return 'cyan'
    }
}

function orderStatusColor(status) {
    switch (status) {
        case 'Створено':
            return '#65a623'
        case 'Готується':
            return '#9ba30094'
        case 'Доставляється':
            return '#c983d2'
        case 'Виконано':
            return '#8ea6ff'
        case 'Скасовано': 
            return '#d31616'
    }
}

export {
    auth,
    hasRole,
    confirmPopup,
    successPopup,
    warningPopup,
    errorPopup,
    formatPrice,
    formatDate,
    serviceColor,
    orderStatusColor,
}
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

function formatPhone(phone) {
    const matches = phone
        .replace(/\D/g, '')
        .match(/(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/)
    return ! matches[2] ? 
        matches[1] : 
        '(' + matches[1] + ') ' + 
        matches[2] + 
        (matches[3] ? '-' + matches[3] : '') + 
        (matches[4] ? '-' + matches[4] : '')
}

function copyToClipboard(text) {
    const textArea = document.createElement('textarea')
    textArea.value = text
    textArea.style.position = 'absolute'
    textArea.style.left = '-999999px'
    document.body.prepend(textArea)
    textArea.select()
    document.execCommand('copy')
    textArea.remove()
}

function daysInMonth(iMonth, iYear) {
    return new Date(iYear, iMonth, 0).getDate()
}

function formatSource(source) {
    return {
        'web': 'Cайт',
        'mobile': 'Mобільний додаток',
        'crm': 'CRM',
    }[source] ?? ''
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
    formatPhone,
    copyToClipboard,
    daysInMonth,
    formatSource,
}
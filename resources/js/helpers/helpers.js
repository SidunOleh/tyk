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

export {
    auth,
    hasRole,
    confirmPopup,
    successPopup,
    warningPopup,
    errorPopup,
}
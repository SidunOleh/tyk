import axios from 'axios'
import { auth } from './helpers/helpers'
import router from './routes'

window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.interceptors.response.use(response => {
    return response
}, async err => {
    if (
        err.response &&
        err.response.status == 419 ||
        (err.response.status == 401 &&
            err.config.url != '/login')
    ) {
        auth.logoutOnClient()

        router.push({ name: 'login' })

        return Promise.reject()
    }

    return Promise.reject(err)
})
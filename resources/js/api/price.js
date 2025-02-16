import { hasRole } from '../helpers/helpers'

export default {
    async calcForRoute(data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/price/calc-for-route', data)

        return res.data
    },
    async getSettings() {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get('/api/price/settings')

        return res.data
    },
    async saveSettings(data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/price/settings', data)

        return res.data
    },
}
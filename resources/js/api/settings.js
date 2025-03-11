import { hasRole } from '../helpers/helpers'

export default {
    async fetch() {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get('/api/settings')

        return res.data
    },
    async save(data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/settings', data)

        return res.data
    },
}
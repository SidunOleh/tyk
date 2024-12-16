import { hasRole } from '../helpers/helpers'

export default {
    async search(s) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get(`/api/clients/search?s=${s}`)

        return res.data
    },
    async create(data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/clients', data)

        return res.data
    },
}
import { hasRole } from '../helpers/helpers'

export default {
    async all() {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get('/api/regions/all')

        return res.data
    },
    async create(data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/regions', data)

        return res.data
    },
    async edit(id, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.put(`/api/regions/${id}`, data)

        return res.data
    },
    async delete(id) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.delete(`/api/regions/${id}`)

        return res.data
    },
}
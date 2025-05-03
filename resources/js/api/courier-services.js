import { hasRole } from '../helpers/helpers'

export default {
    async all() {
        if (!hasRole(['адмін', 'диспетчер', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get('/api/courier-services/all')

        return res.data
    },
    async create(data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/courier-services', data)

        return res.data
    },
    async edit(id, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.put(`/api/courier-services/${id}`, data)

        return res.data
    },
    async delete(id) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.delete(`/api/courier-services/${id}`)

        return res.data
    },
}
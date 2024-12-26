import { hasRole } from '../helpers/helpers'

export default {
    async fetch({ 
        page = 1,
        perpage = 15,
        orderby = 'created_at',
        order = 'DESC',
        s = '',
        filters = {}
    }) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const query = new URLSearchParams({
            page,
            perpage,
            orderby,
            order,
            s,
        })

        for (const field in filters) {
            filters[field]?.forEach(val => query.append(`${field}[]`, val))
        }

        const res = await axios.get(`/api/couriers?${query}`)

        return res.data
    },
    async all() {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get('/api/couriers/all')

        return res.data
    },
    async create(data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/couriers', data)

        return res.data
    },
    async edit(id, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.put(`/api/couriers/${id}`, data)

        return res.data
    },
    async delete(id) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.delete(`/api/couriers/${id}`)

        return res.data
    },
    async bulkDelete(ids) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/couriers/bulk', {
            _method: 'DELETE', ids,
        })

        return res.data
    },
    async createCash(courierId, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post(`/api/couriers/${courierId}/cashes`, data)

        return res.data
    },
    async editCash(courierId, cashId, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.put(`/api/couriers/${courierId}/cashes/${cashId}`, data)

        return res.data
    },
    async deleteCash(courierId, cashId) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.delete(`/api/couriers/${courierId}/cashes/${cashId}`)

        return res.data
    },
}

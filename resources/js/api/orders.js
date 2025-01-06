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

        const res = await axios.get(`/api/orders?${query}`)

        return res.data
    },
    async fetchBetween(start, end) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const query = new URLSearchParams({start, end})

        const res = await axios.get(`/api/orders/between?${query}`)

        return res.data
    },
    async create(data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/orders', data)

        return res.data
    },
    async edit(id, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.put(`/api/orders/${id}`, data)

        return res.data
    },
    async changeStatus(id, status) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post(`/api/orders/${id}/status`, {status})

        return res.data
    },
    async changeCourier(id, courierId) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post(`/api/orders/${id}/courier`, {courier_id: courierId,})

        return res.data
    },
    async delete(id) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.delete(`/api/orders/${id}`)

        return res.data
    },
    async bulkDelete(ids) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/orders/bulk', {
            _method: 'DELETE', ids,
        })

        return res.data
    },
}
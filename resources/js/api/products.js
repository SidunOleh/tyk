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

        const res = await axios.get(`/api/products?${query}`)

        return res.data
    },
    async search(s) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get(`/api/products/search?s=${s}`)

        return res.data
    },
    async create(data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/products', data)

        return res.data
    },
    async edit(id, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.put(`/api/products/${id}`, data)

        return res.data
    },
    async delete(id) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.delete(`/api/products/${id}`)

        return res.data
    },
    async bulkDelete(ids) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/products/bulk', {
            _method: 'DELETE', ids,
        })

        return res.data
    },
}

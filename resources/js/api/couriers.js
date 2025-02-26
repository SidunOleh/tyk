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
    async current() {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get('/api/couriers/current')

        return res.data
    },
    async currentLocations() {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get('/api/couriers/current-locations')

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
}

import { hasRole } from '../helpers/helpers'

export default {
    async get() {
        if (!hasRole(['кур\'єр'])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get('/api/driver')

        return res.data
    },
    async shifts({ 
        page = 1,
        perpage = 15,
        orderby = 'created_at',
        order = 'DESC',
        filters = {}
    }) {
        if (!hasRole(['кур\'єр'])) {
            throw new Error('Заборонено.')
        }

        const query = new URLSearchParams({
            page,
            perpage,
            orderby,
            order,
        })

        for (const field in filters) {
            filters[field]?.forEach(val => query.append(`${field}[]`, val))
        }

        const res = await axios.get(`/api/driver/work-shifts?${query}`)

        return res.data
    },
    async currentWorkShift() {
        if (!hasRole(['кур\'єр'])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get('/api/driver/work-shifts/current')

        return res.data
    },
    async edit(data) {
        if (!hasRole(['кур\'єр'])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.put('/api/driver', data)

        return res.data
    },
    async changePassword(password) {
        if (!hasRole(['кур\'єр'])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/driver/change-password', {password})

        return res.data
    },
    async statistic(start, end, interval) {
        if (!hasRole(['кур\'єр'])) {
            throw new Error('Заборонено.')
        }

        const query = new URLSearchParams({
            start, end, interval
        })


        const res = await axios.get(`/api/driver/statistic?${query}`)

        return res.data
    },
}
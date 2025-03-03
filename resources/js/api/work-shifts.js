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

        const res = await axios.get(`/api/work-shifts?${query}`)

        return res.data
    },
    async current() {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get('/api/work-shifts/current')

        return res.data
    },
    async open() {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/work-shifts/open')

        return res.data
    },
    async workShiftStat(id) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get(`/api/work-shifts/${id}/stat`)

        return res.data
    },
    async close(id, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post(`/api/work-shifts/${id}/close`, data)

        return res.data
    },
    async openDriverWorkShift(workShiftId, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post(`/api/work-shifts/${workShiftId}/drivers/open`, data)

        return res.data
    },
    async editDriverWorkShift(id, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post(`/api/work-shifts/drivers/${id}`, data)

        return res.data
    },
    async driverWorkShiftStat(id) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get(`/api/work-shifts/drivers/${id}/stat`)

        return res.data
    },
    async closeDriverWorkShift(id, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post(`/api/work-shifts/drivers/${id}/close`, data)

        return res.data
    },
    async openDispatcherWorkShift(workShiftId, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post(`/api/work-shifts/${workShiftId}/dispatchers/open`, data)

        return res.data
    },
    async dispatcherWorkShiftStat(id) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get(`/api/work-shifts/dispatchers/${id}/stat`)

        return res.data
    },
    async closeDispatcherWorkShift(id, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post(`/api/work-shifts/dispatchers/${id}/close`, data)

        return res.data
    },
    async editZakladReport(id, data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post(`/api/work-shifts/zaklad-reports/${id}`, data)

        return res.data
    },
}

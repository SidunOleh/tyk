import { hasRole } from '../helpers/helpers'

export default {
    async income(start, end) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const query = new URLSearchParams({
            start,
            end
        })


        const res = await axios.get(`/api/analytics/income?${query}`)

        return res.data
    },
    async orders(start, end) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const query = new URLSearchParams({
            start,
            end
        })


        const res = await axios.get(`/api/analytics/orders?${query}`)

        return res.data
    },
    async products(start, end) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const query = new URLSearchParams({
            start,
            end
        })


        const res = await axios.get(`/api/analytics/products?${query}`)

        return res.data
    },
}
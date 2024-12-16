import { hasRole } from '../helpers/helpers'

export default {
    async create(data) {
        if (!hasRole(['адмін', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/orders', data)

        return res.data
    },
}
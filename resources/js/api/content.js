import { hasRole } from '../helpers/helpers'

export default {
    async fetch() {
        if (!hasRole(['адмін', 'диспетчер', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.get('/api/content')

        return res.data
    },
    async save(data) {
        if (!hasRole(['адмін', 'диспетчер', ])) {
            throw new Error('Заборонено.')
        }

        const res = await axios.post('/api/content', data)

        return res.data
    },
}
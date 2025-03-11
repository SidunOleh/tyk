import { hasRole } from '../helpers/helpers'

export default {
    async upload(file) {
        if (!hasRole(['адмін', 'диспетчер', ])) {
            throw new Error('Заборонено.')
        }

        const data = new FormData
        data.append('image', file)

        const res = await axios.post('/api/images/upload', data)

        return res.data
    },
}
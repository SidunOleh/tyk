export default {
    async fetch() {
        const res = await axios.get('/api/content')

        return res.data
    },
    async save(data) {
        const res = await axios.post('/api/content', data)

        return res.data
    },
}
export default {
    async upload(file) {
        const data = new FormData
        data.append('image', file)

        const res = await axios.post('/api/images/upload', data)

        return res.data
    },
}
export default {
    async login(credentials) {
        const res = await axios.post('/login', credentials)

        return res.data
    },
    async logout() {
        const res = await axios.post('/logout')

        return res.data
    },
    async sendResetLink(email) {
        const res = await axios.post('/api/send-reset-link', { email })

        return res.data
    },
    async resetPassword(credentials) {
        const res = await axios.post('/api/reset-password', credentials)

        return res.data
    },
}
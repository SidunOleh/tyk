import './bootstrap';
import { createApp } from 'vue'
import App from './views/App.vue'
import router from './routes/index'
import Antd from 'ant-design-vue'
import 'ant-design-vue/dist/reset.css'

const app = createApp(App)
app.use(Antd)
app.use(router)
app.mount('#app')
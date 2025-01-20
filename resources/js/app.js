import './bootstrap';
import { createApp } from 'vue'
import App from './views/App.vue'
import router from './routes/index'
import Antd from 'ant-design-vue'
import 'ant-design-vue/dist/reset.css'
import { QuillEditor, } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

QuillEditor.props.globalOptions.default = () => { return { theme: 'snow', } }

const app = createApp(App)
app.use(Antd)
app.use(router)
app.mount('#app')

app.component('QuillEditor', QuillEditor)
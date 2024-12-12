<template>
    <a-upload
        v-model:file-list="fileList"
        list-type="picture-card"
        :customRequest="customRequest"
        @change="fileList => $emit('changeFileList', fileList)">

        <plus-outlined v-if="fileList.length < maxCount"/>

    </a-upload>
</template>

<script>
import { PlusOutlined } from '@ant-design/icons-vue'
import api from '../../api/images'
import { message } from 'ant-design-vue'

export default {
    props: [
        'uploaded',
        'maxCount',
    ],
    components: {
        PlusOutlined,
    },
    data() {
        return {
            fileList: [],
        }
    },  
    methods: {
        async customRequest(obj) {
            try {
                const res = await api.upload(obj.file)

                obj.onSuccess(res)
            } catch (err) {
                obj.onError(err)

                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    watch: {
        uploaded: {
            handler(uploaded) {
                this.fileList = uploaded
            },
            deep: true,
        },
    },
}
</script>

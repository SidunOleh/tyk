<template>
    <a-flex
        :vertical="true"
        :gap="10">
        <a-flex :justify="'flex-end'">
            <a-dropdown>
                <a 
                    class="ant-dropdown-link" 
                    @click.prevent>
                    Дії
                    <DownOutlined/>
                </a>
                <template #overlay>
                    <a-menu>
                        <a-menu-item @click="edit.open = true;">
                            Редагувати дані
                        </a-menu-item>
                        <a-menu-item @click="changePassword.open = true;">
                            Змінити пароль
                        </a-menu-item>
                        <a-menu-item 
                            danger
                            @click="logout">
                            Вийти
                        </a-menu-item>
                    </a-menu>
                </template>
            </a-dropdown>
        </a-flex>
        
        <a-spin :spinning="loading">
            <a-descriptions 
                :column="1"
                bordered>
                <a-descriptions-item label="Ім'я" style="padding: 10px;">
                    {{ driver?.courier?.first_name }}
                </a-descriptions-item>
                <a-descriptions-item label="Прізвище" style="padding: 10px;">
                    {{ driver?.courier?.last_name }}
                </a-descriptions-item>
                <a-descriptions-item label="E-mail" style="padding: 10px;">
                    {{ driver?.email }}
                </a-descriptions-item>
                <a-descriptions-item label="Телефон" style="padding: 10px;">
                    {{ driver?.courier?.phone }}
                </a-descriptions-item>
                <a-descriptions-item label="Телеграм" style="padding: 10px;">
                    {{ driver?.courier?.tg }}
                </a-descriptions-item>
                <a-descriptions-item label="Телеграм бот" style="padding: 10px;">
                    <a-typography-paragraph 
                        style="margin-bottom: 0;"
                        :copyable="{ tooltip: false }">
                        {{ driver?.courier?.tg_link }}
                    </a-typography-paragraph>
                </a-descriptions-item>
                <a-descriptions-item label="Транспорт" style="padding: 10px;">
                    <a-tag 
                        v-for="vehicle in driver?.courier?.vehicles"
                        :bordered="false">
                        {{ vehicle }}
                    </a-tag>
                </a-descriptions-item> 
            </a-descriptions>
        </a-spin>

        <a-tabs>
            <a-tab-pane key="1" tab="Зміни">
                <Shifts/>
            </a-tab-pane>
            <a-tab-pane key="2" tab="Статистика">
                <Statistic/>
            </a-tab-pane>
        </a-tabs>
    </a-flex>

    <EditDriverModal
        v-if="edit.open"
        title="Редагування даних"
        v-model:open="edit.open"
        :item="driver"
        @edit="fetch"/>

    <ChangePasswordModal
        v-if="changePassword.open"
        v-model:open="changePassword.open"/>
</template>

<script>
import api from '../../api/driver'
import { message, } from 'ant-design-vue'
import {
    DownOutlined,
} from '@ant-design/icons-vue'
import Statistic from './Statistic.vue'
import Shifts from './Shifts.vue'
import EditDriverModal from './EditDriverModal.vue'
import ChangePasswordModal from './ChangePasswordModal.vue'
import { auth } from '../../helpers/helpers'

export default {
    components: {
        DownOutlined,
        Statistic,
        Shifts,
        EditDriverModal,
        ChangePasswordModal,
    },
    data() {
        return {
            driver: null,
            edit: {
                open: false,
            },
            changePassword: {
                open: false,
            },
            loading: false,
        }
    },      
    methods: {
        async fetch() {
            try {
                this.loading = true
                const res = await api.get()
                this.driver = res.driver
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },  
        async logout() {
            try {
                await auth.logout()
                location.href = '/login'
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    mounted() {
        this.fetch()
    }
}
</script>
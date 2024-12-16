<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">
        <a-form layout="vertical">
            <a-form-item 
                label="Клієнт"
                :required="true"
                has-feedback
                :validate-status="errors['client_id'] ? 'error' : ''"
                :help="errors.client_id">
                <a-flex
                    :vertical="true"
                    :gap="5">
                    <a-select
                        style="width: 100%"
                        placeholder="Виберіть користувача"
                        :filter-option="false"
                        :options="clientOptions"
                        v-model:value="data.client_id"
                        :showSearch="true"
                        @search="fetchClients">
                        <template 
                            v-if="clients.fetching" 
                            #notFoundContent>
                            <a-spin 
                                style="width: 100%" 
                                size="small"/>
                        </template>
                    </a-select>

                    <a-button 
                        type="primary"
                        @click="this.clientsModal.open = true">
                        Створити клієнта
                    </a-button>
                </a-flex>
            </a-form-item>

            <OrdersList 
                v-if="data.client_id"
                :orders="selectedClient?.orders"
                @repeat="repeatOrder"/>

            <a-form-item 
                label="Сервіс"
                :required="true"
                has-feedback
                :validate-status="errors['service'] ? 'error' : ''"
                :help="errors.service">
                <a-select
                    style="width: 100%"
                    placeholder="Виберіть сервіс"
                    :options="serviceOptions"
                    v-model:value="data.service">
                </a-select>
            </a-form-item>

            <component 
                :is="detailsComponent"
                :errors="errors"
                :repeat="repeat"
                v-model:details="data.details"/>

            <a-form-item 
                label="Сума доставки"
                has-feedback
                :validate-status="errors.shipping_price ? 'error' : ''"
                :help="errors.shipping_price">
                <a-input-number
                    style="width: 100%;"
                    placeholder="Введіть суму доставки"
                    :min="0"
                    v-model:value="data.shipping_price"/>
            </a-form-item>

            <a-form-item 
                label="Час"
                has-feedback
                :validate-status="errors['time'] ? 'error' : ''"
                :help="errors.time">
                <a-date-picker
                    style="width: 100%;"
                    showTime
                    placeholder="Виберіть час"
                    format="YYYY-MM-DD hh:mm"
                    valueFormat="YYYY-MM-DD hh:mm:ss"
                    v-model:value="data.time"/>
            </a-form-item>

            <a-form-item 
                label="Нотатки"
                has-feedback
                :validate-status="errors['notes'] ? 'error' : ''"
                :help="errors.notes">
                <a-textarea
                    placeholder="Введіть нотатки"
                    v-model:value="data.notes"/>
            </a-form-item>

            <div style="margin-bottom: 15px;">
                Повна сума:
                <a-typography-text strong>
                    {{ formatPrice(total) }}
                </a-typography-text>
            </div>

            <a-button
                :loading="loading"
                @click="create">
                Створити
            </a-button>
        </a-form>
    </a-modal>

    <ClientsModal
        v-if="clientsModal.open"
        title="Створення клієнта"
        action="create"
        v-model:open="clientsModal.open"
        @create="addClient"/>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../../api/orders'
import clientsApi from '../../../api/clients'
import OrdersList from './OrdersList.vue'
import FoodShippingDetails from './FoodShippingDetails.vue'
import ShippingDetails from './ShippingDetails.vue'
import TaxiDetails from './TaxiDetails.vue'
import ClientsModal from '../../Clients/Modal.vue'
import { formatPrice } from '../../../helpers/helpers'

export default {
    props: [
        'title',
        'open',
    ],
    components: {
        OrdersList,
        FoodShippingDetails,
        ShippingDetails,
        TaxiDetails,
        ClientsModal,
    },
    data() {
        return {
            data: {
                client_id: null,
                service: null,
                shipping_price: 0,
                time: null,
                notes: '',
                details: {},
            },
            clients: {
                data: [],
                fetching: false,
            },
            clientsModal: {
                open: false,
            },
            repeat: null,
            services: [
                'Доставка їжі',
                'Кур\'єр',
                'Таксі',
            ],
            errors: {},
            loading: false,
        }
    },    
    computed: {
        detailsComponent() {
            switch (this.data.service) {
                case 'Доставка їжі':
                    return 'FoodShippingDetails'
                case 'Кур\'єр':
                    return 'ShippingDetails'
                case 'Таксі':
                    return 'TaxiDetails'
                default:
                    return null
            }
        },
        clientOptions() {
            return this.clients.data.map(client => {
                return {
                    label: `${client.phone}, ${client.first_name} ${client.last_name}`,
                    value: client.id, 
                }
            })
        },
        serviceOptions() {
            return this.services.map(service => {
                return {
                    label: service,
                    value: service, 
                }
            })
        },
        selectedClient() {
            let client = null
            this.clients.data?.forEach(item => {
                if (item.id === this.data.client_id) {
                    client = item
                }
            })

            return client
        },
        total() {
           let subtotal = 0

           if (this.data.service == 'Доставка їжі') {
               subtotal = this.data
                .details
                .order_items
                ?.reduce((acc, item) => acc += item.quantity * item.amount, 0)
           }

           return subtotal + this.data.shipping_price
        },
    },
    methods: {
        formatPrice,
        async fetchClients(s) {
            this.clients.fetching = true
            const res = await clientsApi.search(s)
            this.clients.data = res
            this.clients.fetching = false
        },
        addClient(client) {
            this.clients.data = [client]
            this.data.client_id = client.id
            this.clientsModal.open = false
        },
        repeatOrder(order) {
            this.data.service = order.type

            this.$nextTick(() => this.repeat = JSON.parse(JSON.stringify(order)))
        },
        async create() {
            try {
                this.loading = true
                this.errors = {}
                const data = JSON.parse(JSON.stringify(this.data))
                const res = await api.create(data)
                message.success('Успішно створено.')
                this.$emit('create')
                this.$emit('update:open', false)
                this.$router.push({name: 'dashboard'})
            } catch (err) {
                if (err?.response?.status == 422) {
                    this.errors = err?.response?.data?.errors
                } else {
                    message.error(err?.response?.data?.message ?? err.message)
                }
            } finally {
                this.loading = false
            }
        },
    },
}
</script>
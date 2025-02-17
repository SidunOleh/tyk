<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="e => {if (! e.target.classList.contains('ant-modal-wrap')) $emit('update:open', false);}">
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
                        :showArrow="false"
                        @search="fetchClients">
                        <template 
                            v-if="clients.fetching" 
                            #notFoundContent>
                            <a-spin 
                                style="width: 100%" 
                                size="small"/>
                        </template>
                    </a-select>

                    <a-button @click="this.clientsModal.open = true">
                        Створити клієнта
                    </a-button>
                </a-flex>
            </a-form-item>

            <OrdersList 
                v-if="selectedClient"
                :orders="selectedClient?.orders"
                :current="item?.id"
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
                    v-model:value="data.service"
                    @change="data.details = {}; data.order_items = []">
                </a-select>
            </a-form-item>

            <Cart
                v-if="data.service == 'Доставка їжі'"
                :orderItems="data.order_items"
                :errors="errors"/>
            
            <component 
                :is="detailsComponent"
                :client="selectedClient"
                :details="data.details"
                :errors="errors"/>

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
                <a-button 
                    style="margin-top: 10px;"
                    :loading="calcingPrice"
                    @click="calcShippingPrice">
                    Розрахувати
                </a-button>
            </a-form-item>

            <a-form-item 
                label="Додаткові витрати"
                has-feedback
                :validate-status="errors['additional_costs'] ? 'error' : ''"
                :help="errors.additional_costs">
                <a-input-number
                    style="width: 100%"
                    placeholder="Введіть додаткові витрати"
                    :min="0"
                    v-model:value="data.additional_costs"/>
            </a-form-item>

            <a-form-item 
                label="Час"
                :required="action == 'edit'"
                has-feedback
                :validate-status="errors['time'] ? 'error' : ''"
                :help="errors.time">
                <a-date-picker
                    style="width: 100%;"
                    showTime
                    placeholder="Виберіть час"
                    format="YYYY-MM-DD HH:mm"
                    valueFormat="YYYY-MM-DD HH:mm:ss"
                    v-model:value="data.time"/>
            </a-form-item>

            <a-form-item 
                label="Тривалість(в хвилинах)"
                :required="true"
                has-feedback
                :validate-status="errors['duration'] ? 'error' : ''"
                :help="errors.duration">
                <a-input-number
                    style="width: 100%"
                    placeholder="Введіть тривалість"
                    :min="1"
                    v-model:value="data.duration"/>
            </a-form-item>

            <a-form-item 
                label="Оплачено"
                :required="true"
                has-feedback
                :validate-status="errors['paid'] ? 'error' : ''"
                :help="errors.paid">
                <a-switch v-model:checked="data.paid"/>
            </a-form-item>

            <a-form-item 
                label="Метод оплати"
                has-feedback
                :validate-status="errors['payment_method'] ? 'error' : ''"
                :help="errors.payment_method">
                <a-select
                    style="width: 100%"
                    placeholder="Виберіть метод оплати"
                    :options="paymentMethodOptions"
                    v-model:value="data.payment_method">
                </a-select>
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

            <a-flex :gap="5">
                <a-button
                    type="primary"
                    :loading="loading"
                    @click="action == 'create' ? create() : edit()">
                    Зберегти
                </a-button>

                <a-button
                    v-if="action == 'edit'"
                    type="primary"
                    @click="copy">
                    Копіювати
                </a-button>
            </a-flex>
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
import priceApi from '../../../api/price'
import OrdersList from './OrdersList.vue'
import FoodShippingDetails from './FoodShippingDetails.vue'
import Cart from './Cart.vue'
import ShippingDetails from './ShippingDetails.vue'
import TaxiDetails from './TaxiDetails.vue'
import ClientsModal from '../../Clients/Modal.vue'
import { 
    formatPrice,
    copyToClipboard, 
} from '../../../helpers/helpers'

export default {
    props: [
        'title',
        'open',
        'action',
        'item',
        'client',
    ],
    components: {
        OrdersList,
        FoodShippingDetails,
        Cart,
        ShippingDetails,
        TaxiDetails,
        ClientsModal,
    },
    data() {
        return {
            data: {
                client_id: null,
                service: null,
                details: {},
                order_items: [],
                shipping_price: 0,
                additional_costs: 0,
                time: null,
                duration: 30,
                paid: false,
                payment_method: null,
                notes: '',
            },
            clients: {
                data: [],
                fetching: false,
            },
            clientsModal: {
                open: false,
            },
            services: [
                'Доставка їжі',
                'Кур\'єр',
                'Таксі',
            ],
            paymentMethods: [
                'Карта',
                'Готівка',
            ],
            errors: {},
            loading: false,
            calcingPrice: false,
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
                    label: `${client.phone}, ${client.full_name ?? ''}`,
                    value: client.id, 
                }
            })
        },
        selectedClient() {
            let client = null
            this.clients.data.forEach(item => {
                if (item.id === this.data.client_id) {
                    client = item
                }
            })
            
            return client
        },
        serviceOptions() {
            return this.services.map(service => {
                return {
                    value: service, 
                }
            })
        },
        paymentMethodOptions() {
            return this.paymentMethods.map(paymentMethod => {
                return {
                    value: paymentMethod, 
                }
            })
        },
        total() {
           let subtotal = 0

           if (this.data.service == 'Доставка їжі') {
                subtotal = this.data
                    .order_items
                    ?.reduce((acc, item) => acc += item.quantity * item.amount, 0)
           }

           return subtotal + this.data.shipping_price + this.data.additional_costs
        },
    },
    methods: {
        formatPrice,
        setData(data) {
            data = JSON.parse(JSON.stringify(data))

            this.clients.data = [data.client]
            
            data.client_id = data.client.id
            data.service = data.type

            if (data.service == 'Доставка їжі') {
                data.order_items = data.order_items?.map(item => {
                    return {
                        id: item.id,
                        name: item.product.name,
                        quantity: item.quantity,
                        amount: item.product.price,
                        product_id: item.product.id,
                    }
                }) ?? []
            }

            this.data = data
        },
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
            this.data.details = order.details

            if (this.data.service == 'Доставка їжі') {
                this.data.order_items = order.order_items?.map(item => {
                    return {
                        id: item.id,
                        name: item.product.name,
                        quantity: item.quantity,
                        amount: item.product.price,
                        product_id: item.product.id,
                    }
                }) ?? []
            }
        },
        async create() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.create(this.prepareData())
                message.success('Успішно збережено.')
                this.$emit('create')
                this.$emit('update:open', false)
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
        async edit() {
            try {
                this.loading = true
                this.errors = {}
                const res = await api.edit(this.data.id, this.prepareData())
                message.success('Успішно збережено.')
                this.$emit('edit', res.order)
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
        prepareData() {
            const data = JSON.parse(JSON.stringify(this.data))

            if (data.service != 'Доставка їжі') {
                delete data.order_items
            }

            return data
        },
        copy() {
            let text = ''
            switch (this.data.service) {
                case 'Доставка їжі':
                    text = this.foodShippingText()
                break
                case 'Кур\'єр':
                    text = this.shippingText()
                break
                case 'Таксі':
                    text = this.taxiText()
                break
            }

            copyToClipboard(text)

            message.success('Скопійовано в буфер обміну.')
        },
        foodShippingText() {
            return `${this.data.service} №${this.data.number}
Клієнт: ${this.selectedClient.full_name}, ${this.selectedClient.phone}
Товари: ${this.data.order_items?.map(orderItem => `${orderItem.name} x ${orderItem.quantity}`).join(' | ')}
Куди: ${this.data.details.food_to?.map(address => address.address).join(' | ')}
Метод оплати: ${this.data.payment_method ?? ''}`
        },
        shippingText() {
            return `${this.data.service} №${this.data.number}
Клієнт: ${this.selectedClient.full_name}, ${this.selectedClient.phone}
Звідки: ${this.data.details.shipping_from?.address}
Куди: ${this.data.details.shipping_to?.map(address => address.address).join(' | ')}
Метод оплати: ${this.data.payment_method ?? ''}`
        },
        taxiText() {
            return `${this.data.service} №${this.data.number}
Клієнт: ${this.selectedClient.full_name}, ${this.selectedClient.phone}
Звідки: ${this.data.details.taxi_from?.address}
Куди: ${this.data.details.taxi_to?.map(address => address.address).join(' | ')}
Метод оплати: ${this.data.payment_method ?? ''}`
        },
        async calcShippingPrice() {
            const request = {
                route: [],
                service: this.data.service,
            }

            if (this.data.service == 'Доставка їжі') {
                request.route.push({
                    lat: 49.8094, 
                    lng: 24.9014, 
                })
                request.route = request.route.concat(this.data.details.food_to)
            }

            if (this.data.service == 'Кур\'єр') {
                if (this.data.details.shipping_from) {
                    request.route.push(this.data.details.shipping_from)
                }

                if (this.data.details.shipping_to.length) {
                    request.route = request.route.concat(this.data.details.shipping_to)
                }

                request.courier_service = this.data.details.shipping_type
            }

            if (this.data.service == 'Таксі') {
                if (this.data.details.taxi_from) {
                    request.route.push(this.data.details.taxi_from)
                }

                if (this.data.details.taxi_to.length) {
                    request.route = request.route.concat(this.data.details.taxi_to)
                }
            }

            if (
                ! request.service ||
                request.route.length < 2 ||
                (this.data.service == 'Кур\'єр' && ! request.courier_service)
            ) {
                message.error('Заповніть необхідні поля.')
                return
            }

            try {
                this.calcingPrice = true
                const data = await priceApi.calcForRoute(request)
                this.data.shipping_price = data.price
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.calcingPrice = false
            }
        },
    },
    mounted() {
        if (this.item) {
            this.setData(this.item)
        }

        if (this.client) {
            this.clients.data = [this.client]
            this.data.client_id = this.client.id
        }
    }
}
</script>
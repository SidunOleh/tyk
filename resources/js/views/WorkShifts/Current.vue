<template>
    <a-spin :spinning="loading">
        <template v-if="current">
            <a-flex
                :align="'center'"
                :gap="10">
                <a-typography-title 
                    style="margin-bottom: 0;"
                    :level="5">
                    Відкрита {{ formatDate(current.start) }}
                </a-typography-title>

                <a-typography-link 
                    type="danger"
                    @click="close.open = true">
                    Закрити
                </a-typography-link>
            </a-flex>

            <div style="margin-top: 20px;">
                <a-button 
                    style="margin-bottom: 20px;"
                    type="primary"
                    @click="addDriver.open = true">
                    Додати водія 
                </a-button>

                <DriversList 
                    :drivers="current.drivers"
                    @edit="driver => {editDriver.open = true; editDriver.record = driver;}"
                    @close="driver => {closeDriver.open = true; closeDriver.record = driver;}"/>
            </div>
        </template>

        <template v-else>
            <a-flex
                :align="'center'"
                :gap="10">
                <a-typography-title 
                    style="margin-bottom: 0;"
                    :level="5">
                    Немає відкритої зміни
                </a-typography-title>

                <a-typography-link @click="confirmPopup(open, 'Ви впевнені що хочете відкрити зміну?')">
                    Відкрити 
                </a-typography-link >
            </a-flex>
        </template>
    </a-spin>

    <DriverModal
        v-if="addDriver.open"
        title="Відкриття зміни для водія"
        v-model:open="addDriver.open"
        action="open"
        :couriers="freeCouriers"
        :cars="freeCars"
        :workShift="current"
        @open="fetchCurrent"/>

    <DriverModal
        v-if="editDriver.open"
        :title="`Редагування зміни водія ${editDriver.record.courier.first_name} ${editDriver.record.courier.last_name}`"
        v-model:open="editDriver.open"
        action="edit"
        :couriers="freeCouriers"
        :cars="freeCars"
        :workShift="current"
        :item="editDriver.record"
        @edit="fetchCurrent"/>

    <CloseDriverModal
        v-if="closeDriver.open"
        :title="`Закриття зміни водія ${closeDriver.record.courier.first_name} ${closeDriver.record.courier.last_name}`"
        v-model:open="closeDriver.open"
        :item="closeDriver.record"
        @close="fetchCurrent"/>

    <CloseModal
        v-if="close.open"
        title="Закриття зміни"
        v-model:open="close.open"
        :item="current"
        @close="fetchCurrent"/>
</template>

<script>
import DriverModal from './DriverModal.vue'
import CloseDriverModal from './CloseDriverModal.vue'
import CloseModal from './CloseModal.vue'
import { message } from 'ant-design-vue'
import api from '../../api/work-shifts'
import { 
    confirmPopup, 
    formatDate,
} from '../../helpers/helpers'
import couriersApi from '../../api/couriers'
import carsApi from '../../api/cars'
import DriversList from './DriversList.vue'

export default {
    components: {
        DriverModal,
        DriversList,
        CloseDriverModal,
        CloseModal,
    },
    data() {
        return {
            current: null,
            loading: false,
            addDriver: {
                open: false,
            },
            editDriver: {
                open: false,
                record: null,
            },
            closeDriver: {
                open: false,
                record: null,
            },
            close: {
                open: false,
            },
            couriers: [],
            cars: [],
        }
    },  
    computed: {
        freeCouriers() {
           return this.couriers.filter(courier => ! this
                .current
                .drivers
                .find(driver => {
                    if (
                        this.editDriver.open && 
                        this.editDriver.record.courier.id == courier.id
                    ) {
                        return false
                    }

                    if (
                        driver.status == 'open' 
                        && driver.courier.id == courier.id
                    ) {
                        return true
                    }
                }))
        },
        freeCars() {
            return this.cars.filter(car => ! this
                .current
                .drivers
                .find(driver => {
                    if (
                        this.editDriver.open && 
                        this.editDriver.record.car.id == car.id
                    ) {
                        return false
                    }

                    if (
                        driver.status == 'open' 
                        && driver.car_id == car.id
                    ) {
                        return true
                    }
                }))
        },
    },
    methods: {
        confirmPopup,
        formatDate,
        async fetchCurrent() {
            try {
                this.loading = true
                const res = await api.current()
                this.current = res.work_shift
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        async fetchCouriers() {
            try {
                this.couriers = await couriersApi.all()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async fetchCars() {
            try {
                this.cars = await carsApi.all()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async open() {
            try {
                this.loading = true
                const res = await api.open()
                this.current = res.work_shift
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
    },
    mounted() {
        this.fetchCurrent()
        this.fetchCouriers()
        this.fetchCars()
    },
}
</script>
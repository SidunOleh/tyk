<template>
    <a-flex 
        :vertical="true"
        :gap="10">
        <CurrentShift/>
        <ClosedShifts/>
    </a-flex>
</template>

<script>
import ClosedShifts from './ClosedShifts.vue'
import CurrentShift from './CurrentShift.vue';

export default {
    components: {
        CurrentShift,
        ClosedShifts,
    },
}
</script>
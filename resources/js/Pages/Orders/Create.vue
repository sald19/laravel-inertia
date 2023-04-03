<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

defineProps({ test: String })

const APP_ID = 'PRySaOJZezUFyPr6'
const ASTROPAY_EXTERNAL_DEPOSIT_ID = null

const now = new Date().toLocaleString()

const ASTROPAY_CONFIG = {
  environment: 'sandbox', //Environments available: 'production' and 'sandbox'
  onDepositStatusChange: (depositResult) => getDepositStatus(depositResult), //Subscribes to every transaction status update.
  onClose: (depositResult) => iframeClosed(depositResult),
}

const paymentId = computed(() => usePage().props.paymentId)

const data = AstropaySDK.init(APP_ID, ASTROPAY_CONFIG)

function sendData() {
  const data = router.visit('/orders', {
    method: 'post',
    preserveState: true,
  })

  console.log({ data })
}
</script>

<template>
  <AppLayout title="Create Post">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Post
      </h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mt-5 md:mt-0">
          <button
            class="h-10 px-6 font-semibold rounded-md bg-black text-white"
            type="submit"
            @click="sendData"
          >
            Buy now
          </button>

          <p>{{ now }}</p>
          <p>{{ test }}</p>
          <p>payment id: {{ paymentId }}</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

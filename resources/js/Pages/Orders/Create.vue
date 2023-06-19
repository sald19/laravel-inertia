<script setup>
import { watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { router, useForm } from '@inertiajs/vue3'

defineProps({ test: String })

const form = useForm({
  title: null,
  active: false,
})

watch(
  () => form.active,
  (newValue) => {
    console.log('input-active:', newValue)
    submit()
  }
)

const submit = () => {
  form.post('/orders', {
    preserveScroll: true,
    onSuccess: () => {
      console.log('success')
    },
    onError: (errors) => {
      form.reset('active')
      console.log('errors:', errors)
    },
  })
}
</script>

<template>
  <AppLayout title="Create Order">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Order
      </h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mt-5 md:mt-0">
          <form @submit.prevent="submit">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
              <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <div v-if="form.active" class="col-span-3 sm:col-span-2">
                  <label
                    for="title"
                    class="block text-sm font-medium text-gray-700"
                  >
                    Title
                  </label>
                  <div class="mt-1 rounded-md shadow-sm">
                    <input
                      id="title"
                      v-model="form.title"
                      :class="[
                        'block w-full pr-10 focus:outline-none sm:text-sm rounded-md',
                        form.errors.title
                          ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500'
                          : 'border-gray-300',
                      ]"
                      name="title"
                      type="text"
                    />
                  </div>
                  <small
                    v-if="form.errors.title"
                    class="mt-2 text-sm text-red-600"
                    name="title"
                  >
                    {{ form.errors.title }}
                  </small>
                </div>

                <div class="col-span-3 sm:col-span-2">
                  <label
                    for="content"
                    class="block text-sm font-medium text-gray-700"
                  >
                    Content
                  </label>
                  <input v-model="form.active" type="checkbox" name="active" />
                  <small
                    v-if="form.errors.active"
                    class="mt-2 text-sm text-red-600"
                    name="title"
                  >
                    {{ form.errors.active }}
                  </small>
                </div>
              </div>

              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button
                  :disabled="form.processing"
                  class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                  type="submit"
                >
                  Save
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

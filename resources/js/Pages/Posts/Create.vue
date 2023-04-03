<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { Form, Field, ErrorMessage } from 'vee-validate'
import { array, object, string } from 'yup'
// import Tiptap from '@/Components/Tiptap.vue'

const schema = object({
  content: object({
    content: array(),
    type: string(),
  }),
  title: string().required().min(3),
})

const form = useForm({
  content: {},
  title: '',
})

function submit(_, actions) {
  form.post('/posts', {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: (errors) => {
      actions.setErrors(errors)
    },
  })
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
          <Form
            v-slot="{ errors }"
            :validation-schema="schema"
            @submit="submit"
          >
            <div class="shadow sm:rounded-md sm:overflow-hidden">
              <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <div class="col-span-3 sm:col-span-2">
                  <label
                    for="title"
                    class="block text-sm font-medium text-gray-700"
                  >
                    Title
                  </label>
                  <div class="mt-1 rounded-md shadow-sm">
                    <Field
                      id="title"
                      v-model="form.title"
                      :class="[
                        'block w-full pr-10 focus:outline-none sm:text-sm rounded-md',
                        errors.title
                          ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500'
                          : 'border-gray-300',
                      ]"
                      name="title"
                      type="text"
                    />
                  </div>
                  <ErrorMessage
                    class="mt-2 text-sm text-red-600"
                    name="title"
                  />
                </div>

                <div class="col-span-3 sm:col-span-2">
                  <label
                    for="content"
                    class="block text-sm font-medium text-gray-700"
                  >
                    Content
                  </label>
                  <Field v-slot="{ errorMessage }" name="content">
                    <Tiptap
                      v-model="form.content"
                      :class="[
                        'focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border rounded-md',
                        errorMessage
                          ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500'
                          : 'border-gray-300',
                      ]"
                    />
                  </Field>
                  <ErrorMessage
                    class="mt-2 text-sm text-red-600"
                    name="content"
                  />
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
          </Form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

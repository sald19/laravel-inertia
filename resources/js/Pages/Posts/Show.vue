<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { computed } from 'vue'
import { formatDistanceToNow, isToday, format } from 'date-fns'

import TiptapRenderer from '@/Components/TiptapRenderer.vue'

function errorReport() {
  new Error(`Test error ${test}`)
}

const props = defineProps({
  post: Object,
})

const humaneDate = computed(() => {
  const date = new Date(props.post.created_at)

  return isToday(date) ? formatDistanceToNow(date) : format(date, 'MMMM d, y')
})
</script>

<template>
  <AppLayout title="Post">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post</h2>
      <button @click="errorReport">click</button>
    </template>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 rounded-xl">
      <div
        class="h-60 w-full bg-cover bg-center"
        style="
          background-image: url(https://images.unsplash.com/photo-1554629947-334ff61d85dc?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&h=666&q=80);
        "
      ></div>
      <div class="bg-white p-4 sm:p-8">
        <div
          class="font-inter font-extrabold text-2xl text-black tracking-tight"
        >
          {{ post.title }}
        </div>
        <div class="mt-1 font-medium text-sm text-slate-500">
          {{ humaneDate }} · 4 min read
        </div>

        <TiptapRenderer :content="post.content" class="content" />
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.content {
  height: 3000px;
}
.content ::v-deep(p) {
  @apply mt-4 leading-7 text-slate-500;
}
</style>

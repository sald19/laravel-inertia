<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { formatDistanceToNow, isToday, format } from 'date-fns'

defineProps({ posts: Array })

function formatPostDate(date) {
  date = new Date(date)

  return isToday(date) ? formatDistanceToNow(date) : format(date, 'MMMM d, y')
}
</script>

<template>
  <AppLayout title="Posts">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post</h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="relative border-l border-gray-200">
          <Link
            v-for="post in posts"
            :key="post.id"
            as="article"
            href="posts/create"
            class="mb-10 ml-8 cursor-pointer"
          >
            <span
              class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-blue-200 rounded-full ring-8 ring-white"
            >
              <svg
                class="w-3 h-3 text-blue-600"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </span>
            <h3
              class="flex items-center mb-1 text-lg font-semibold text-gray-900"
            >
              {{ post.title }}
              <span
                class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded ml-3"
              >
                Latest
              </span>
            </h3>
            <time
              :datetime="post.created_at"
              class="block mb-2 text-sm font-normal leading-none text-gray-400"
            >
              Published on {{ formatPostDate(post.created_at) }}
            </time>
            <p class="mb-4 text-base font-normal text-gray-500">
              {{ post.content }}
            </p>
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

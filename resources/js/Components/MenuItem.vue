<script setup>
defineProps({
  action: Function,
  icon: String,
  title: String,
  isActive: Function,
})
</script>

<template>
  <button
    :class="[
      {
        ['isActive']: isActive(),
      },
      `w-8 h-8 text-gray-800 rounded fill-current items-center p-2`,
    ]"
    :title="title"
    @click="action"
  >
    <font-awesome-icon :icon="['fa-solid', icon]" />
  </button>
</template>

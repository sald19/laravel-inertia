<script setup>
import MenuItem from '@/Components/MenuItem.vue'

const props = defineProps({
  editor: Object,
})

const items = [
  {
    icon: 'bold',
    title: 'Bold',
    action: () => props.editor.chain().focus().toggleBold().run(),
    isActive: () => props.editor.isActive('bold'),
  },
  {
    icon: 'italic',
    title: 'Italic',
    action: () => props.editor.chain().focus().toggleItalic().run(),
    isActive: () => props.editor.isActive('italic'),
  },
  {
    icon: 'strikethrough',
    title: 'Strike',
    action: () => props.editor.chain().focus().toggleStrike().run(),
    isActive: () => props.editor.isActive('strike'),
  },
]
</script>

<template>
  <div class="flex justify-around border-b border-gray-100 py-1">
    <template v-for="(item, index) in items">
      <div
        v-if="item.type === 'divider'"
        :key="`divider${index}`"
        class="divide-x divide-gray-200"
      />
      <menu-item v-else :key="index" v-bind="item" />
    </template>
  </div>
</template>

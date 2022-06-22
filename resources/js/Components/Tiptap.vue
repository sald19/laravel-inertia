<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import Highlight from '@tiptap/extension-highlight'
import StarterKit from '@tiptap/starter-kit'

import MenuBar from '@/Components/MenuBar.vue'

const props = defineProps({
  modelValue: Object,
})

const emit = defineEmits(['update:modelValue'])

const editor = useEditor({
  content: props.modelValue,
  editorProps: {
    attributes: {
      class:
        'prose prose-sm sm:prose focus:outline-none min-h-full w-full min-w-full p-2',
    },
  },
  extensions: [Highlight, StarterKit],
  onUpdate: ({ editor }) => {
    emit('update:modelValue', editor.getJSON())
  },
})
</script>

<template>
  <div>
    <div v-if="editor" class="border border-gray-300 bg-white rounded">
      <menu-bar :editor="editor" />
      <editor-content :editor="editor" class="min-h-24" />
    </div>
  </div>
</template>

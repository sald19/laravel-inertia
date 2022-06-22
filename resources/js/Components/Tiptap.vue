<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import Highlight from '@tiptap/extension-highlight'
import StarterKit from '@tiptap/starter-kit'

import MenuBar from '@/Components/MenuBar.vue'

const editor = useEditor({
  content: '<p>I’m running Tiptap with Vue.js. 🎉</p>',
  editorProps: {
    attributes: {
      class:
        'prose prose-sm sm:prose focus:outline-none min-h-full w-full min-w-full p-2',
    },
  },
  extensions: [Highlight, StarterKit],
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

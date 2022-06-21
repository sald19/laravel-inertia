<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import MenuBar from '@/Components/MenuBar.vue'

const editor = useEditor({
  content: '<p>I’m running Tiptap with Vue.js. 🎉</p>',
  extensions: [StarterKit],
})
</script>

<template>
  <div>
    <div v-if="editor">
      <menu-bar :editor="editor" />
      <editor-content :editor="editor" />
    </div>
  </div>
</template>

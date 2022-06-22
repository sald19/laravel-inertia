<script setup>
import { generateHTML } from '@tiptap/html'
import Highlight from '@tiptap/extension-highlight'
import StarterKit from '@tiptap/starter-kit'

const props = defineProps({
  content: Object,
})

const html = generateHTML(props.content, [Highlight, StarterKit])
</script>

<template>
  <div v-html="html"></div>
</template>

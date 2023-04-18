<script setup>
import { computed } from 'vue'
import { EditorContent, useEditor } from '@tiptap/vue-3'
import { usePage } from '@inertiajs/vue3'
import * as Y from 'yjs'

import { HocuspocusProvider } from '@hocuspocus/provider'
import Collaboration from '@tiptap/extension-collaboration'
import CollaborationCursor from '@tiptap/extension-collaboration-cursor'
import Highlight from '@tiptap/extension-highlight'
import StarterKit from '@tiptap/starter-kit'

import MenuBar from '@/Components/MenuBar.vue'

const props = defineProps({
  modelValue: Object,
  document: {
    required: false,
    type: Number,
  },
})

const emit = defineEmits(['update:modelValue'])

const ydoc = new Y.Doc()
const colors = [
  '#958DF1',
  '#F98181',
  '#FBBC88',
  '#FAF594',
  '#70CFF8',
  '#94FADB',
  '#B9F18D',
]

const user = computed(() => usePage().props.auth.user)

const collaborationExtensions = computed(() => {
  return props.document
    ? [
        Collaboration.configure({
          document: ydoc,
        }),
        CollaborationCursor.configure({
          provider,
          user: {
            id: user.value.id,
            name: user.value.name,
            color: randomColor.value,
          },
        }),
      ]
    : []
})

console.log({ docuemnt: props.document })

const randomColor = computed(() => {
  return colors[Math.floor(Math.random() * colors.length)]
})

const provider = new HocuspocusProvider({
  url: `ws://${window.location.host}:6001/collaboration`,
  name: `document:${props.document}`,
  document: ydoc,
})

const editor = useEditor({
  content: props.document ? '' : props.modelValue,
  editorProps: {
    attributes: {
      class:
        'prose prose-sm sm:prose focus:outline-none min-h-full w-full min-w-full p-2',
    },
  },
  extensions: [
    Highlight,
    StarterKit.configure({ history: false }),
    ...collaborationExtensions.value,
  ],
  onUpdate: ({ editor }) => {
    emit('update:modelValue', editor.getJSON())
  },
})
</script>

<template>
  <div>
    <div v-if="editor" class="border border-gray-300 bg-white rounded">
      <menu-bar :editor="editor" />
      <editor-content :editor="editor" class="ProseMirror min-h-24" />
    </div>
  </div>
</template>

<style scoped>
.ProseMirror ::v-deep(p.is-editor-empty:first-child::before) {
  content: attr(data-placeholder);
  float: left;
  color: #adb5bd;
  pointer-events: none;
  height: 0;
}

/* Give a remote user a caret */
.ProseMirror ::v-deep(.collaboration-cursor__caret) {
  position: relative;
  margin-left: -1px;
  margin-right: -1px;
  border-left: 1px solid #0d0d0d;
  border-right: 1px solid #0d0d0d;
  word-break: normal;
  pointer-events: none;
}

.ProseMirror ::v-deep(.collaboration-cursor__label) {
  position: absolute;
  top: -1.4em;
  left: -1px;
  font-size: 12px;
  font-style: normal;
  font-weight: 600;
  line-height: normal;
  user-select: none;
  color: #0d0d0d;
  padding: 0.1rem 0.3rem;
  border-radius: 3px 3px 3px 0;
  white-space: nowrap;
}
</style>

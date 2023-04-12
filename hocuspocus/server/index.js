import { TiptapTransformer } from '@hocuspocus/transformer'
import { Server } from '@hocuspocus/server'
import { Database } from '@hocuspocus/extension-database'
import { Logger } from '@hocuspocus/extension-logger'
import { PrismaClient } from '@prisma/client'

import Highlight from '@tiptap/extension-highlight'
import StarterKit from '@tiptap/starter-kit'

import { encodeStateAsUpdate } from 'yjs'

const prisma = new PrismaClient()
const server = Server.configure({
  extensions: [
    new Logger(),
    new Database({
      fetch: async ({ documentName }) => {
        const [_, id] = documentName.split(':')

        return new Promise((resolve, reject) => {
          prisma.posts
            .findUnique({
              where: {
                id: parseInt(id),
              },
            })
            .then((post) => {
              const ydoc = TiptapTransformer.toYdoc(post.content, `default`, [
                Highlight,
                StarterKit,
              ])

              const encoded = encodeStateAsUpdate(ydoc)

              resolve(encoded)
            })
        })
      },
    }),
  ],
})

export default server

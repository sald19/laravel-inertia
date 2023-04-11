import express from 'express'
import expressWebsockets from 'express-ws'
import { TiptapTransformer } from '@hocuspocus/transformer'
import { Server } from '@hocuspocus/server'
import { Database } from '@hocuspocus/extension-database'
import { PrismaClient } from '@prisma/client'

import Highlight from '@tiptap/extension-highlight'
import StarterKit from '@tiptap/starter-kit'

import { encodeStateAsUpdate } from 'yjs'

const prisma = new PrismaClient()
const hocuspocus = Server.configure({
  extensions: [
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

const { app } = expressWebsockets(express())

app.get('/', (request, response) => {
  response.send('Hello World!')
})

app.ws('/collaboration/:document', (websocket, request) => {
  const context = {
    user: {
      id: 1234,
      name: 'Jane',
    },
  }

  hocuspocus.handleConnection(
    websocket,
    request,
    request.params.document,
    context
  )
})

app.listen(1234, () => console.log('Listening on http://127.0.0.1:1234'))

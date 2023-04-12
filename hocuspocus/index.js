import express from 'express'
import expressWebsockets from 'express-ws'

import server from './server/index.js'

const { app } = expressWebsockets(express())

app.get('/', (response) => {
  response.send('Hello World!')
})

app.ws('/collaboration/:document', (websocket, request) => {
  const context = {
    user: {
      id: 1234,
      name: 'Jane',
    },
  }

  server.handleConnection(websocket, request, request.params.document, context)
})

app.listen(1234, () => console.log('Listening on http://127.0.0.1:1234'))

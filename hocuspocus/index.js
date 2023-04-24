import express from 'express'
import expressWebsockets from 'express-ws'

import server from './server/index.js'

const { app } = expressWebsockets(express())

app.get('/', (request, response) => {
  response.send('Hello World!!')
})

app.ws('/collaboration', (websocket, request) => {
  server.handleConnection(websocket, request, request.params.document)
})

app.listen(6001, () => console.log('Listening on http://127.0.0.1:6001'))

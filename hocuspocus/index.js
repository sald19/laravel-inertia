import express from 'express'
import expressWebsockets from 'express-ws'
import { Server } from '@hocuspocus/server'
const hocuspocus = Server.configure({
  async onConnect({ connection }) {
    console.log('onConnect')
  },
  async onChange(data) {
    console.log({ onChange: data })
  },
})

const { app } = expressWebsockets(express())

app.get('/', (request, response) => {
  response.send('Hello World!')
})

app.ws('/collaboration/:document', (websocket, request) => {
  console.log({ request: request.params })

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

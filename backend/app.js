import express from 'express'
import morgan from 'morgan'
import helmet from 'helmet'
import cors from 'cors'
import { Server } from 'socket.io'
import { createServer } from 'http'

import api from './api/index.js'

const app = express()
const httpServer = createServer()
const io = new Server(httpServer, { cors: { origin: "*" } })

app.use(morgan("dev"))
app.use(helmet())
app.use(cors({
    origin: "*"
}))

app.use(express.json())

app.use(api)

io.on("connection", (socket) => {
    console.log("socket has been connected!", socket.id)
    socket.emit("test!", "TEST!")
})


httpServer.listen(5002)

export default app
const express = require('express')
const morgan = require('morgan')
const helmet = require('helmet')
const cors = require('cors')
const { Server } = require('socket.io')
const { createServer } = require('http')

const api = require('./api/index.js')

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

module.exports = app
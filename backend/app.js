import express from 'express'
import morgan from 'morgan'
import helmet from 'helmet'

import api from './api/index.js'

const app = express()

app.use(morgan("dev"))
app.use(helmet())

app.use(express.json())

app.use(api)


export default app